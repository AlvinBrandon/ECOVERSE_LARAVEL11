<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ChatPollingController extends Controller
{
    /**
     * Get recent chat messages for a specific room
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_rooms,id',
            'last_id' => 'nullable|integer'
        ]);

        $roomId = $request->input('room_id');
        $lastId = $request->input('last_id', 0);

        // Check if user is a member of this room or is admin
        $userInRoom = ChatRoom::where('id', $roomId)
            ->whereHas('users', function($query) {
                $query->where('users.id', Auth::id());
            })
            ->exists();
            
        if (!$userInRoom && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access to this room'], 403);
        }

        $messages = ChatMessage::where('room_id', $roomId)
            ->where('id', '>', $lastId)
            ->with(['user', 'parent', 'parent.user'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                $parent = $message->parent;
                // Defensive: If parent is array, object, or null
                $parentData = null;
                if ($parent && is_object($parent)) {
                    $parentData = [
                        'id' => property_exists($parent, 'id') ? $parent->id : null,
                        'message' => property_exists($parent, 'message') ? $parent->message : '',
                        'username' => (property_exists($parent, 'user') && $parent->user && property_exists($parent->user, 'name')) ? $parent->user->name : 'Unknown User',
                    ];
                }
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'user_id' => $message->user_id,
                    'username' => $message->user->name,
                    'created_at' => $message->created_at->diffForHumans(),
                    'is_mine' => $message->user_id === Auth::id(),
                    'role' => $message->user->role ?? 'user',
                    'is_feedback' => $message->is_feedback ?? false,
                    'parent_id' => $message->parent_id,
                    'parent' => $parentData
                ];
            });

        return response()->json([
            'messages' => $messages,
            'last_id' => $messages->count() ? $messages->last()->id : $lastId
        ]);
    }

    /**
     * Send a new chat message
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        // Only log essential information, not the entire request
        \Log::info('Message request received', [
            'user_id' => Auth::id(),
            'room_id' => $request->input('room_id')
        ]);
        
        $request->validate([
            'room_id' => 'required|exists:chat_rooms,id',
            'message' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:chat_messages,id',
            'is_feedback' => 'nullable|boolean'
        ]);

        // Check for duplicate message within 5 seconds
        $recentDuplicate = ChatMessage::where('user_id', Auth::id())
            ->where('room_id', $request->input('room_id'))
            ->where('message', $request->input('message'))
            ->where('created_at', '>=', now()->subSeconds(5))
            ->exists();

        if ($recentDuplicate) {
            return response()->json(['error' => 'Duplicate message detected'], 429);
        }

        $roomId = $request->input('room_id');
        
        // Check if user is a member of this room or is admin
        $userInRoom = ChatRoom::where('id', $roomId)
            ->whereHas('users', function($query) {
                $query->where('users.id', Auth::id());
            })
            ->exists();
            
        if (!$userInRoom && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'You cannot send messages to this room'], 403);
        }
        
        // If there's a parent_id, verify it belongs to the same room
        if ($request->filled('parent_id')) {
            $parentMessage = ChatMessage::find($request->input('parent_id'));
            if (!$parentMessage || $parentMessage->room_id != $roomId) {
                return response()->json(['error' => 'Invalid parent message'], 422);
            }
        }

        $message = new ChatMessage();
        $message->room_id = $roomId;
        $message->user_id = Auth::id();
        $message->message = $request->input('message');
        
        // Handle parent message (for replies)
        if ($request->filled('parent_id')) {
            $message->parent_id = $request->input('parent_id');
        }
        
        // Handle feedback flag (for admin feedback)
        if ($request->filled('is_feedback') && $request->input('is_feedback') == 1 && Auth::user()->role === 'admin') {
            $message->is_feedback = true;
        }
        
        $message->save();

        \Log::info('Message saved', ['id' => $message->id]);

        // Load parent message if exists
        $messageWithRelations = ChatMessage::with(['user', 'parent', 'parent.user'])
            ->find($message->id);
            
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'user_id' => $message->user_id,
                'username' => Auth::user()->name,
                'role' => Auth::user()->role,
                'created_at' => $message->created_at->diffForHumans(),
                'is_mine' => true,
                'is_feedback' => $message->is_feedback ?? false,
                'parent_id' => $message->parent_id,
                'parent' => $message->parent_id ? [
                    'id' => $messageWithRelations->parent->id,
                    'message' => $messageWithRelations->parent->message,
                    'username' => $messageWithRelations->parent->user ? $messageWithRelations->parent->user->name : 'Unknown User',
                ] : null,
            ]
        ]);
    }

    /**
     * Get online users
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnlineUsers(Request $request)
    {
        $request->validate([
            'room_id' => 'nullable|exists:chat_rooms,id',
        ]);
        
        // Users active in the last 5 minutes are considered online
        $activeThreshold = Carbon::now()->subMinutes(5);
        
        $query = User::where('last_active_at', '>=', $activeThreshold);
        
        // If a room_id is provided, filter users by room membership
        if ($request->filled('room_id')) {
            $roomId = $request->input('room_id');
            $query->whereHas('rooms', function($q) use ($roomId) {
                $q->where('chat_rooms.id', $roomId);
            });
        }
        
        $users = $query->select('id', 'name', 'last_active_at')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'online' => true,
                    'last_seen' => $user->last_active_at->diffForHumans()
                ];
            });
            
        return response()->json(['users' => $users]);
    }

    /**
     * Update user typing status
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setTypingStatus(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_rooms,id',
            'is_typing' => 'required|boolean'
        ]);

        // We could store typing status in cache or a database table
        // For simplicity, we'll just use the session for now
        $key = 'typing_' . $request->input('room_id') . '_' . Auth::id();
        $expiresAt = Carbon::now()->addSeconds(10); // Typing status expires after 10 seconds
        
        if ($request->input('is_typing')) {
            session([$key => $expiresAt]);
        } else {
            session()->forget($key);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Get users who are currently typing
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypingUsers(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_rooms,id',
        ]);

        $roomId = $request->input('room_id');
        $typingUsers = [];
        $now = Carbon::now();
        
        // Get all users in this room
        $roomUsers = ChatRoom::find($roomId)->users;
        
        // Check each user's session for typing status
        foreach ($roomUsers as $user) {
            if ($user->id === Auth::id()) {
                continue; // Skip current user
            }
            
            $key = 'typing_' . $roomId . '_' . $user->id;
            $expiresAt = session($key);
            
            // If typing status exists and hasn't expired
            if ($expiresAt && $now->lt(Carbon::parse($expiresAt))) {
                $typingUsers[] = $user->id;
            }
        }
        
        return response()->json(['typing_users' => $typingUsers]);
    }

    /**
     * Get count of unread messages
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        // Get user's chat rooms
        $userRooms = Auth::user()->rooms()->pluck('chat_rooms.id');
        
        // Count messages that:
        // 1. Are in rooms the user belongs to
        // 2. Were not sent by the current user
        // 3. Have no read_at timestamp or it's null
        // Note: This assumes you have a read_at column in your chat_messages table
        try {
            if (Schema::hasColumn('chat_messages', 'read_at')) {
                $unreadCount = ChatMessage::whereIn('room_id', $userRooms)
                    ->where('user_id', '!=', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            } else {
                // Fallback if read_at column doesn't exist yet
                $unreadCount = 0;
                \Log::warning('read_at column does not exist in chat_messages table. Returning 0 for unread count.');
            }
        } catch (\Exception $e) {
            \Log::error('Error getting unread count: ' . $e->getMessage());
            $unreadCount = 0;
        }
        
        return response()->json(['unread_count' => $unreadCount]);
    }
}
