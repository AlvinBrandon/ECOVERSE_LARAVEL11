<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $productId;
    public $batchId;
    public $quantity;
    public $userId;

    public function __construct($type, $productId, $batchId, $quantity, $userId)
    {
        $this->type = $type; // add, deduct, transfer
        $this->productId = $productId;
        $this->batchId = $batchId;
        $this->quantity = $quantity;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('inventory');
    }

    public function broadcastAs()
    {
        return 'InventoryUpdated';
    }
}
