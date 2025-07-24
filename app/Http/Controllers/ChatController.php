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
            }])
            ->leftJoin('chat_messages', function($join) {
                $join->on('chat_rooms.id', '=', 'chat_messages.room_id')
                     ->whereRaw('chat_messages.id = (SELECT MAX(id) FROM chat_messages WHERE room_id = chat_rooms.id)');
            })
            ->select('chat_rooms.*', 'chat_messages.created_at as last_message_at')
            ->orderByRaw('COALESCE(last_message_at, chat_rooms.updated_at) DESC')
            ->get();
            
            $allChats = true;
        } else {
            $rooms = ChatRoom::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->with(['messages' => function($query) {
                $query->latest()->take(1);
            }])
            ->leftJoin('chat_messages', function($join) {
                $join->on('chat_rooms.id', '=', 'chat_messages.room_id')
                     ->whereRaw('chat_messages.id = (SELECT MAX(id) FROM chat_messages WHERE room_id = chat_rooms.id)');
            })
            ->select('chat_rooms.*', 'chat_messages.created_at as last_message_at')
            ->orderByRaw('COALESCE(last_message_at, chat_rooms.updated_at) DESC')
            ->get();
            
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
        
        // For admin users, show all chat rooms ordered by latest activity
        if ($user->role === 'admin') {
            $rooms = ChatRoom::withCount('messages')
                ->with(['messages' => function($query) {
                    $query->latest()->take(1);
                }])
                ->leftJoin('chat_messages', function($join) {
                    $join->on('chat_rooms.id', '=', 'chat_messages.room_id')
                         ->whereRaw('chat_messages.id = (SELECT MAX(id) FROM chat_messages WHERE room_id = chat_rooms.id)');
                })
                ->select('chat_rooms.*', 'chat_messages.created_at as last_message_at')
                ->orderByRaw('COALESCE(last_message_at, chat_rooms.updated_at) DESC')
                ->get();
            $allChats = true;
        } else {
            $rooms = ChatRoom::whereHas('users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->withCount('messages')
            ->with(['messages' => function($query) {
                $query->latest()->take(1);
            }])
            ->leftJoin('chat_messages', function($join) {
                $join->on('chat_rooms.id', '=', 'chat_messages.room_id')
                     ->whereRaw('chat_messages.id = (SELECT MAX(id) FROM chat_messages WHERE room_id = chat_rooms.id)');
            })
            ->select('chat_rooms.*', 'chat_messages.created_at as last_message_at')
            ->orderByRaw('COALESCE(last_message_at, chat_rooms.updated_at) DESC')
            ->get();
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
        
        // Get users that can be messaged based on role-based interaction rules
        $allowedUsers = $this->getAllowedChatUsers($user);
        
        $topic = $request->query('topic');
        
        return view('chat.start', compact('user', 'allowedUsers', 'topic'));
    }

    /**
     * Show user selection for direct messaging
     *
     * @return \Illuminate\Http\Response
     */
    public function selectUser()
    {
        $user = Auth::user();
        
        // Get users that can be messaged based on role-based interaction rules
        $allowedUsers = $this->getAllowedChatUsers($user);
        
        return view('chat.select-user', compact('user', 'allowedUsers'));
    }

    /**
     * Show recipient selection for users with multiple chat partners
     * This method provides a quick message interface for users who can chat with many others
     *
     * @return \Illuminate\Http\Response
     */
    public function selectRecipient()
    {
        $user = Auth::user();
        
        // Get users that can be messaged based on role-based interaction rules
        $allowedUsers = $this->getAllowedChatUsers($user);
        
        // Get existing chat rooms with these users, ordered by latest activity
        $existingChats = ChatRoom::whereHas('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->with(['users' => function($query) use ($user) {
            $query->where('users.id', '!=', $user->id);
        }, 'messages' => function($query) {
            $query->latest()->take(1);
        }])
        ->leftJoin('chat_messages', function($join) {
            $join->on('chat_rooms.id', '=', 'chat_messages.room_id')
                 ->whereRaw('chat_messages.id = (SELECT MAX(id) FROM chat_messages WHERE room_id = chat_rooms.id)');
        })
        ->select('chat_rooms.*', 'chat_messages.created_at as last_message_at')
        ->where('type', 'private')
        ->orderByRaw('COALESCE(last_message_at, chat_rooms.updated_at) DESC')
        ->get();
        
        // Organize users into categories: existing chats and new potential chats
        $existingChatUsers = $existingChats->flatMap(function($room) {
            return $room->users;
        })->pluck('id')->toArray();
        
        $newChatUsers = $allowedUsers->whereNotIn('id', $existingChatUsers);
        
        return view('chat.select-recipient', compact('user', 'allowedUsers', 'existingChats', 'newChatUsers'));
    }

    /**
     * Start direct chat with a specific user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startDirectChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $targetUser = User::findOrFail($request->user_id);

        // Check if users can chat
        if (!$this->canUsersChat($user, $targetUser)) {
            return redirect()->back()
                ->withErrors(['user_id' => 'You are not allowed to chat with this user based on your role.'])
                ->withInput();
        }

        // Check if chat room already exists between these users
        $existingRoom = ChatRoom::whereHas('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->whereHas('users', function($query) use ($targetUser) {
            $query->where('users.id', $targetUser->id);
        })->where('type', 'private')
        ->whereRaw('(SELECT COUNT(*) FROM chat_room_user WHERE chat_room_id = chat_rooms.id) = 2')
        ->first();

        if ($existingRoom) {
            // Add message to existing room
            ChatMessage::create([
                'user_id' => $user->id,
                'room_id' => $existingRoom->id,
                'message' => $request->message,
            ]);

            return redirect()->route('chat.history', $existingRoom->id)
                ->with('success', 'Message sent successfully!');
        }

        // Create new private room
        $room = ChatRoom::create([
            'name' => "Chat between {$user->name} and {$targetUser->name}",
            'type' => 'private',
            'description' => 'Direct message conversation',
        ]);

        // Add both users to the room
        $room->users()->attach([$user->id, $targetUser->id]);

        // Create initial message
        ChatMessage::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.history', $room->id)
            ->with('success', 'Chat started successfully!');
    }

    /**
     * Send a quick message to a selected recipient
     * This method allows users to send messages quickly from the recipient selection page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendQuickMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);

        // Check if users can chat
        if (!$this->canUsersChat($user, $recipient)) {
            return redirect()->back()
                ->withErrors(['recipient_id' => 'You are not allowed to chat with this user based on your role.'])
                ->withInput();
        }

        // Check if chat room already exists between these users
        $existingRoom = ChatRoom::whereHas('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->whereHas('users', function($query) use ($recipient) {
            $query->where('users.id', $recipient->id);
        })->where('type', 'private')
        ->whereRaw('(SELECT COUNT(*) FROM chat_room_user WHERE chat_room_id = chat_rooms.id) = 2')
        ->first();

        if ($existingRoom) {
            // Add message to existing room
            ChatMessage::create([
                'user_id' => $user->id,
                'room_id' => $existingRoom->id,
                'message' => $request->message,
            ]);

            // Check if user wants to go to chat or stay on recipient selection
            if ($request->has('goto_chat')) {
                return redirect()->route('chat.history', $existingRoom->id)
                    ->with('success', 'Message sent successfully!');
            } else {
                return redirect()->route('chat.select-recipient')
                    ->with('success', "Message sent to {$recipient->name}!");
            }
        }

        // Create new private room
        $room = ChatRoom::create([
            'name' => "Chat between {$user->name} and {$recipient->name}",
            'type' => 'private',
            'description' => 'Direct message conversation',
        ]);

        // Add both users to the room
        $room->users()->attach([$user->id, $recipient->id]);

        // Create initial message
        ChatMessage::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'message' => $request->message,
        ]);

        // Check if user wants to go to chat or stay on recipient selection
        if ($request->has('goto_chat')) {
            return redirect()->route('chat.history', $room->id)
                ->with('success', 'Chat started successfully!');
        } else {
            return redirect()->route('chat.select-recipient')
                ->with('success', "Message sent to {$recipient->name}! Chat room created.");
        }
    }

    /**
     * Get allowed chat users based on role-based interaction rules
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getAllowedChatUsers($user)
    {
        $userRole = $user->getCurrentRole();
        
        switch ($userRole) {
            case 'admin':
                // Admin interacts with supplier, wholesaler and staff only
                return User::where('id', '!=', $user->id)
                    ->whereIn('role_as', [3, 4, 5]) // staff, supplier, wholesaler
                    ->get();
                
            case 'supplier':
                // Supplier interacts with admin only
                return User::where('id', '!=', $user->id)
                    ->where('role_as', 1) // admin
                    ->get();
                
            case 'wholesaler':
                // Wholesaler interacts with admin, retailer and staff only
                return User::where('id', '!=', $user->id)
                    ->whereIn('role_as', [1, 2, 3]) // admin, retailer, staff
                    ->get();
                
            case 'retailer':
                // Retailer interacts with customer and wholesaler only
                return User::where('id', '!=', $user->id)
                    ->whereIn('role_as', [0, 5]) // customer, wholesaler
                    ->get();
                
            case 'customer':
                // Customer interacts with retailers only
                return User::where('id', '!=', $user->id)
                    ->where('role_as', 2) // retailer
                    ->get();
                
            case 'staff':
                // Staff can interact with admin, wholesaler (based on typical business logic)
                return User::where('id', '!=', $user->id)
                    ->whereIn('role_as', [1, 5]) // admin, wholesaler
                    ->get();
                
            default:
                // Default: no chat access
                return collect();
        }
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
        
        // Validate that current user can chat with all selected users
        $selectedUsers = User::whereIn('id', $request->user_ids)->get();
        foreach ($selectedUsers as $selectedUser) {
            if (!$this->canUsersChat($user, $selectedUser)) {
                return redirect()->back()
                    ->withErrors(['user_ids' => "You are not allowed to chat with {$selectedUser->name} based on your role."])
                    ->withInput();
            }
        }
        
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
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        
        $user = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);
        
        // Check if users can chat based on role restrictions
        if (!$this->canUsersChat($user, $recipient)) {
            return redirect()->back()
                ->withErrors(['recipient_id' => 'You are not allowed to chat with this user based on your role.'])
                ->withInput();
        }
        
        // Check if a direct chat room already exists between these users
        $existingRoom = ChatRoom::whereHas('users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->whereHas('users', function($query) use ($recipient) {
            $query->where('users.id', $recipient->id);
        })->where('type', 'private')
        ->whereRaw('(SELECT COUNT(*) FROM chat_room_user WHERE chat_room_id = chat_rooms.id) = 2')
        ->first();
        
        if ($existingRoom) {
            // Add message to existing room
            $message = ChatMessage::create([
                'user_id' => $user->id,
                'room_id' => $existingRoom->id,
                'message' => $request->message,
            ]);
            
            // Broadcast the message
            broadcast(new NewChatMessage($message))->toOthers();
            
            return redirect()->route('chat.history', $existingRoom->id)
                ->with('success', 'Message sent to existing conversation with ' . $recipient->name);
        }
        
        // Create chat room with appropriate naming
        $topicMap = [
            'order' => 'Order Support',
            'product' => 'Product Inquiry', 
            'account' => 'Account Help',
            'technical' => 'Technical Support',
            'billing' => 'Billing Questions',
            'general' => 'General Inquiry',
            'other' => 'General Support',
        ];
        
        $roomSubject = $topicMap[$request->subject] ?? 'Chat';
        $roomName = "{$roomSubject}: {$user->name} ↔ {$recipient->name}";
        
        // Create the room
        $room = ChatRoom::create([
            'name' => $roomName,
            'type' => 'private',
            'description' => "Direct conversation about {$request->subject} between {$user->getCurrentRole()} and {$recipient->getCurrentRole()}",
        ]);
        
        // Add both users to the room
        $room->users()->attach([$user->id, $recipient->id]);
        
        // Create initial message with the user's query
        $message = ChatMessage::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'message' => $request->message,
        ]);
        
        // Broadcast the message
        broadcast(new NewChatMessage($message))->toOthers();
        
        // Notify the recipient
        $recipient->notify(new \App\Notifications\NewChatMessage($message));
        
        return redirect()->route('chat.history', $room->id)
            ->with('success', "Chat started with {$recipient->name}. Your message has been sent.");
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
