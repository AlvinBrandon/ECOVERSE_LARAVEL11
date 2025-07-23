<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'phone',
        'about',
        'password_confirmation',
        'role',
        'eco_points',
        'last_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ecoPointTransactions()
    {
        return $this->hasMany(EcoPointTransaction::class);
    }

    public function isAdmin() { return $this->role === 'admin' || $this->role_as == 1; }
    public function isSupplier() { return $this->role === 'supplier' || $this->role_as == 4; }
    public function isStaff() { return $this->role === 'staff' || $this->role_as == 3; }
    public function isWholesaler() { return $this->role === 'wholesaler' || $this->role_as == 5; }
    public function isRetailer() { return $this->role === 'retailer' || $this->role_as == 2; }
    public function isCustomer() { return $this->role === 'customer' || $this->role_as == 0; }
    
    /**
     * Get user's current role name based on role_as
     */
    public function getCurrentRole()
    {
        return match($this->role_as) {
            1 => 'admin',
            2 => 'retailer', 
            3 => 'staff',
            4 => 'supplier',
            5 => 'wholesaler',
            0 => 'customer',
            default => 'unknown',
        };
    }
    
    /**
     * Refresh user role data - call this when role is updated
     */
    public function refreshRole()
    {
        $this->refresh();
        // Clear any role-based cache
        Cache::forget("user_role_{$this->id}");
        Cache::forget("user_permissions_{$this->id}");
        return $this;
    }

    /**
     * The chat rooms that belong to the user.
     */
    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_user')
            ->withTimestamps();
    }
    
    /**
     * Get the chat messages sent by the user.
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
    
    /**
     * Check if the user has unread messages.
     * 
     * @return bool
     */
    public function hasUnreadMessages()
    {
        return ChatMessage::whereHas('room', function($query) {
                $query->whereHas('users', function($q) {
                    $q->where('users.id', $this->id);
                });
            })
            ->where('user_id', '!=', $this->id)
            ->whereNull('read_at')
            ->exists();
    }
    
    /**
     * Get count of unread messages for the user.
     * 
     * @return int
     */
    public function unreadMessagesCount()
    {
        return ChatMessage::whereHas('room', function($query) {
                $query->whereHas('users', function($q) {
                    $q->where('users.id', $this->id);
                });
            })
            ->where('user_id', '!=', $this->id)
            ->whereNull('read_at')
            ->count();
    }
}
