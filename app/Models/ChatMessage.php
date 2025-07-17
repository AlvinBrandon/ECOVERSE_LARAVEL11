<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'room_id', 'message', 'read_at', 'parent_id', 'is_feedback'];
    
    protected $casts = [
        'read_at' => 'datetime',
        'is_feedback' => 'boolean',
    ];
    
    /**
     * Get the user that sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the chat room that the message belongs to.
     */
    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'room_id');
    }
    
    /**
     * Get the parent message this is replying to.
     */
    public function parent()
    {
        return $this->belongsTo(ChatMessage::class, 'parent_id');
    }
    
    /**
     * Get replies to this message.
     */
    public function replies()
    {
        return $this->hasMany(ChatMessage::class, 'parent_id');
    }
    
    /**
     * Check if this message is a reply to another message.
     */
    public function isReply()
    {
        return !is_null($this->parent_id);
    }
}
