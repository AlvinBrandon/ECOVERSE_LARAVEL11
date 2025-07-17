<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
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

    public function isAdmin() { return $this->role === 'admin'; }
    public function isSupplier() { return $this->role === 'supplier'; }
    public function isStaff() { return $this->role === 'staff'; }
    public function isWholesaler() { return $this->role === 'wholesaler'; }

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
