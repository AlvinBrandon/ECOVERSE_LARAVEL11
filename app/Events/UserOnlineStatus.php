<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnlineStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $status;
    public $roomId;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $status, $roomId = null)
    {
        $this->user = $user;
        $this->status = $status; // 'online', 'offline', or 'typing'
        $this->roomId = $roomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // If this is a typing notification for a specific room
        if ($this->status === 'typing' && $this->roomId) {
            return [
                new PrivateChannel('chat.room.' . $this->roomId),
            ];
        }
        
        // Otherwise broadcast general status
        return [
            new Channel('user.status'),
        ];
    }
    
    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        if ($this->status === 'typing') {
            return 'typing';
        }
        return 'status.update';
    }
}
