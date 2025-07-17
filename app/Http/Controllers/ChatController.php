<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Events\UserOnlineStatus;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display the chat dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // For admin users, show all chat rooms to ensure they have access to all conversations
        if ($user->role === 'admin') {
            $rooms = ChatRoom::with(['messages' => function($query) {
                $query->latest()->take(1);
            }])->get();
            
            $allChats = true;
        } else {
            $rooms = ChatRoom::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->with(['messages' => function($query) {
                $query->latest()->take(1);
            }])->get();
            
            $allChats = false;
        }
        
        return view('chat.index', compact('user', 'rooms', 'allChats'));
    }

    /**
     * Show chat history.
     *
     * @param int $roomId
     * @return \Illuminate\Http\Response
     */
    public function history($roomId = null)
    {
        $user = Auth::user();
        
        // For admin users, show all chat rooms
        if ($user->role === 'admin') {
            $rooms = ChatRoom::all();
            $allChats = true;
        } else {
            $rooms = ChatRoom::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();
            $allChats = false;
        }
        
        $currentRoom = null;
        $messages = [];
        
        if ($roomId) {
            $currentRoom = ChatRoom::findOrFail($roomId);
            
            // Check if user has access to this room (using the new helper method)
            if (!$currentRoom->userHasAccess($user)) {
                abort(403, 'You do not have access to this chat room');
            }
            
            $messages = $currentRoom->messages()->with('user')->latest()->paginate(50);
            
            // Mark messages as read
            ChatMessage::where('room_id', $roomId)
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            
            // If admin is viewing a room they're not part of, add them to the room
            if ($user->role === 'admin' && !$currentRoom->users()->where('users.id', $user->id)->exists()) {
                $currentRoom->users()->attach($user->id);
            }
        }
        
        return view('chat.history', compact('user', 'rooms', 'currentRoom', 'messages', 'allChats'));
    }

    /**
     * Start a new chat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function start(Request $request)
    {
        $user = Auth::user();
        
        // Get users that can be messaged based on user role
        // For example, admins can message anyone, while customers can only message admins
        $userRole = $user->role ?? 'customer';
        
        $usersQuery = User::where('id', '!=', $user->id);
        
        if ($userRole === 'admin' || $userRole === 'staff') {
            // Admins and staff can message anyone
        } elseif ($userRole === 'vendor') {
            // Vendors can message admins, staff, and customers
            $usersQuery->whereIn('role', ['admin', 'staff', 'customer']);
        } elseif ($userRole === 'customer') {
            // Customers can message admins, staff, and vendors
            $usersQuery->whereIn('role', ['admin', 'staff', 'vendor']);
        }
        
        $users = $usersQuery->get();
        $topic = $request->query('topic');
        
        return view('chat.start', compact('user', 'users', 'topic'));
    }
    
    /**
     * Create a new chat room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:public,private,group',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'description' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        // Create the room
        $room = ChatRoom::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
        ]);
        
        // Add current user and selected users to the room
        $userIds = $request->user_ids;
        if (!in_array($user->id, $userIds)) {
            $userIds[] = $user->id;
        }
        
        // Add all admin users to the chat room to ensure they receive all messages
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            if (!in_array($admin->id, $userIds)) {
                $userIds[] = $admin->id;
            }
        }
        
        $room->users()->attach($userIds);
        
        // Create initial message if description is provided
        if ($request->filled('description')) {
            ChatMessage::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'message' => $request->description,
            ]);
        }
        
        return redirect()->route('chat.history', $room->id)
            ->with('success', 'Chat room created successfully!');
    }
    
    /**
     * Send a new chat message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'room_id' => 'required|exists:chat_rooms,id',
            'parent_id' => 'nullable|exists:chat_messages,id',
            'is_feedback' => 'nullable|boolean',
        ]);
        
        $user = Auth::user();
        
        // Check if user has access to this room (using the helper method)
        $room = ChatRoom::findOrFail($request->room_id);
        if (!$room->userHasAccess($user)) {
            abort(403, 'You do not have access to this chat room');
        }
        
        // If admin is sending a message but not in the room yet, add them
        if ($user->role === 'admin' && !$room->users()->where('users.id', $user->id)->exists()) {
            $room->users()->attach($user->id);
        }
        
        // Determine if this is admin feedback
        $isFeedback = $request->is_feedback && $user->role === 'admin';
        
        $message = ChatMessage::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'message' => $request->message,
            'parent_id' => $request->parent_id,
            'is_feedback' => $isFeedback,
        ]);
        
        // No broadcast needed with polling system
        
        // Notify other users in the chat room
        $room->users()
            ->where('users.id', '!=', $user->id)
            ->get()
            ->each(function($recipient) use ($message) {
                $recipient->notify(new \App\Notifications\NewChatMessage($message));
            });
            
        // If message is from admin, ensure all other admins are notified as well
        if ($user->role === 'admin') {
            // Notify other admins not already in the room
            User::where('role', 'admin')
                ->where('id', '!=', $user->id)
                ->whereNotIn('id', $room->users->pluck('id')->toArray())
                ->get()
                ->each(function($admin) use ($message, $room) {
                    $admin->notify(new \App\Notifications\NewChatMessage($message));
                    // Add other admins to the room as well
                    $room->users()->syncWithoutDetaching([$admin->id]);
                });
                
            // If this is a feedback reply to a specific message, send a specific notification
            // to the original message sender if they're not an admin
            if ($message->isReply() && $message->is_feedback) {
                $originalMessageSender = $message->parent->user;
                if ($originalMessageSender && $originalMessageSender->role !== 'admin') {
                    $originalMessageSender->notify(new \App\Notifications\NewChatMessage($message));
                }
            }
        }
        // If message is not from admin, notify admins not in the room
        else {
            User::where('role', 'admin')
                ->whereNotIn('id', $room->users->pluck('id')->toArray())
                ->get()
                ->each(function($admin) use ($message, $room) {
                    $admin->notify(new \App\Notifications\NewChatMessage($message));
                    // Add admins to the room automatically
                    $room->users()->syncWithoutDetaching([$admin->id]);
                });
        }
        
        // Always return JSON for better compatibility with fetch API
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => $message->load(['user', 'parent.user']),
            ]);
        }
        
        return redirect()->back();
    }
    
    /**
     * Send admin feedback to a specific message.
     * This is a specialized version of sendMessage that's explicitly for admin feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendAdminFeedback(Request $request)
    {
        // Only admins can provide feedback
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admins can provide feedback.'], 403);
        }
        
        $request->validate([
            'message' => 'required|string',
            'room_id' => 'required|exists:chat_rooms,id',
            'parent_id' => 'required|exists:chat_messages,id',
        ]);
        
        // Force feedback flag to be true for admin feedback
        $request->merge(['is_feedback' => true]);
        
        // Reuse the sendMessage method with the feedback flag
        return $this->sendMessage($request);
    }
    
    /**
     * Get messages for a specific room via API.
     *
     * @param  int  $roomId
     * @return \Illuminate\Http\Response
     */
    public function getMessages($roomId)
    {
        $user = Auth::user();
        
        $room = ChatRoom::findOrFail($roomId);
        // Check access using the helper method
        if (!$room->userHasAccess($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // If admin is viewing a room they're not part of, add them to the room
        if ($user->role === 'admin' && !$room->users()->where('users.id', $user->id)->exists()) {
            $room->users()->attach($user->id);
        }
        
        // Include parent message and user information
        $messages = $room->messages()
            ->with(['user', 'parent.user'])
            ->latest()
            ->paginate(50);
        
        // Mark messages as read
        ChatMessage::where('room_id', $roomId)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->json($messages);
    }
    
    /**
     * Update user online status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:online,offline,typing',
            'room_id' => 'nullable|exists:chat_rooms,id',
        ]);
        
        $user = Auth::user();
        
        // Update user status in database (optional)
        if ($request->status !== 'typing') {
            $user->update([
                'last_active_at' => $request->status === 'online' ? now() : null,
            ]);
        }
        
        // With polling system, no broadcasting needed
        // Status changes are handled through the database and polling
        
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Process a new chat submission from the start form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startChat(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Find admin users to create a chat with
        $adminUsers = User::where('role', 'admin')->get();
        
        if ($adminUsers->isEmpty()) {
            return redirect()->back()->with('error', 'No administrators available for chat at the moment.');
        }
        
        // Create chat room with the topic as name
        $topicMap = [
            'order' => 'Order Support',
            'product' => 'Product Inquiry',
            'account' => 'Account Help',
            'other' => 'General Support',
        ];
        
        $roomName = $topicMap[$request->subject] ?? 'Support Chat';
        
        // Create the room
        $room = ChatRoom::create([
            'name' => $roomName . ' - ' . now()->format('M d, Y'),
            'type' => 'private',
            'description' => 'Support chat: ' . $request->subject,
        ]);
        
        // Add current user and admin users to the room
        $userIds = [$user->id];
        foreach ($adminUsers as $admin) {
            $userIds[] = $admin->id;
        }
        
        $room->users()->attach($userIds);
        
        // Create initial message with the user's query
        $message = ChatMessage::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'message' => $request->message,
        ]);
        
        // Broadcast the message using Reverb
        broadcast(new NewChatMessage($message))->toOthers();
        
        // Notify admin users
        foreach ($adminUsers as $admin) {
            $admin->notify(new \App\Notifications\NewChatMessage($message));
        }
        
        return redirect()->route('chat.history', $room->id)
            ->with('success', 'Your support request has been sent. An administrator will respond shortly.');
    }
    
    /**
     * Mark messages as read in a specific chat room
     *
     * @param Request $request
     * @param int $roomId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $roomId)
    {
        $user = $request->user();
        $room = ChatRoom::findOrFail($roomId);
        
        // Verify user belongs to this room
        if (!$room->users()->where('users.id', $user->id)->exists() && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Mark all messages not from the current user as read
        ChatMessage::where('room_id', $roomId)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->json(['success' => true]);
    }

    /**
     * Display the chat demo page.
     *
     * @return \Illuminate\Http\Response
     */
    public function demo()
    {
        return view('chat.demo');
    }
}
