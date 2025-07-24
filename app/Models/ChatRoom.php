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
     * Check if a user has access to this room based on role restrictions
     * 
     * @param \App\Models\User|int $user User model or user ID
     * @return bool
     */
    public function userHasAccess($user)
    {
        if (is_numeric($user)) {
            $userId = $user;
            $userModel = User::find($userId);
            $userRole = $userModel ? $userModel->getCurrentRole() : null;
        } else {
            $userId = $user->id;
            $userRole = $user->getCurrentRole();
            $userModel = $user;
        }
        
        // Admins always have access to all rooms
        if ($userRole === 'admin') {
            return true;
        }
        
        // Check if user is a member of the room
        $isMember = $this->users()->where('users.id', $userId)->exists();
        
        if (!$isMember) {
            return false;
        }
        
        // Additional role-based validation: ensure all room members can interact
        $roomUsers = $this->users()->get();
        foreach ($roomUsers as $roomUser) {
            if ($roomUser->id !== $userId && !$this->canUsersChat($userModel, $roomUser)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check if two users can chat based on role interaction rules
     *
     * @param  \App\Models\User  $user1
     * @param  \App\Models\User  $user2
     * @return bool
     */
    private function canUsersChat($user1, $user2)
    {
        $role1 = $user1->getCurrentRole();
        $role2 = $user2->getCurrentRole();
        
        // Define allowed interactions (bidirectional)
        $allowedInteractions = [
            'admin' => ['supplier', 'wholesaler', 'staff'],
            'supplier' => ['admin'],
            'wholesaler' => ['admin', 'retailer', 'staff'],
            'retailer' => ['customer', 'wholesaler'],
            'customer' => ['retailer'],
            'staff' => ['admin', 'wholesaler']
        ];
        
        // Check if role1 can chat with role2
        if (isset($allowedInteractions[$role1]) && in_array($role2, $allowedInteractions[$role1])) {
            return true;
        }
        
        // Check if role2 can chat with role1 (bidirectional check)
        if (isset($allowedInteractions[$role2]) && in_array($role1, $allowedInteractions[$role2])) {
            return true;
        }
        
        return false;
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
