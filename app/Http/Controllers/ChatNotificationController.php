<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatNotificationController extends Controller
{
    /**
     * Mark messages as read
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_rooms,id',
            'message_ids' => 'nullable|array',
            'message_ids.*' => 'integer|exists:chat_messages,id'
        ]);

        $roomId = $request->input('room_id');
        
        // Check if user is a member of this room
        $userInRoom = ChatRoom::where('id', $roomId)
            ->whereHas('users', function($query) {
                $query->where('users.id', Auth::id());
            })
            ->exists();
            
        if (!$userInRoom && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access to this room'], 403);
        }
        
        $query = ChatMessage::where('chat_room_id', $roomId)
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at');
            
        // If specific message IDs are provided, only mark those
        if ($request->filled('message_ids')) {
            $query->whereIn('id', $request->input('message_ids'));
        }
        
        $count = $query->update(['read_at' => Carbon::now()]);
        
        return response()->json([
            'success' => true,
            'marked_count' => $count
        ]);
    }
}
