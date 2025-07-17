<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Chat room channel - users who are members of the chat room or admins can listen
Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    if ($user->role === 'admin') {
        return true; // Admins always have access to all chat rooms
    }
    $room = ChatRoom::findOrFail($roomId);
    return $room->users()->where('users.id', $user->id)->exists();
});

// Public channel for user status updates
Broadcast::channel('user.status', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
