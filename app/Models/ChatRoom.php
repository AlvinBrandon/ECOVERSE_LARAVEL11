<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description'];
    
    /**
     * The users that belong to the chat room.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_user')
            ->withTimestamps();
    }
    
    /**
     * Get the messages for the chat room.
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'room_id');
    }
    
    /**
     * Check if a user has access to this room (either as a member or as an admin)
     * 
     * @param \App\Models\User|int $user User model or user ID
     * @return bool
     */
    public function userHasAccess($user)
    {
        if (is_numeric($user)) {
            $userId = $user;
            $userRole = User::find($userId)->role ?? null;
        } else {
            $userId = $user->id;
            $userRole = $user->role;
        }
        
        // Admins always have access to all rooms
        if ($userRole === 'admin') {
            return true;
        }
        
        // Check if user is a member of the room
        return $this->users()->where('users.id', $userId)->exists();
    }
    
    /**
     * Count unread messages for a specific user
     * 
     * @param int $userId
     * @return int
     */
    public function unreadCount($userId)
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
