<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Str;

class NewChatMessage extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->line('You have a new message in: ' . $this->message->room->name)
            ->line('From: ' . $this->message->user->name);
        
        // If this is admin feedback, label it as such
        if ($this->message->is_feedback) {
            $mailMessage->line('ADMIN FEEDBACK:');
        }
        
        // If this is a reply to a message, include the original message
        if ($this->message->isReply() && $this->message->parent) {
            $mailMessage->line('In response to: "' . Str::limit($this->message->parent->message, 100) . '"');
        }
        
        $mailMessage->line('Message: ' . $this->message->message)
            ->action('View Message', url('/chat/history/' . $this->message->room_id))
            ->line('Thank you for using Ecoverse!');
            
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $data = [
            'room_id' => $this->message->room_id,
            'message' => $this->message->message,
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user->name,
            'timestamp' => $this->message->created_at,
            'is_feedback' => $this->message->is_feedback,
        ];
        
        return $data;
    }
        
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $data = [
            'room_id' => $this->message->room_id,
            'message' => Str::limit($this->message->message, 50),
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user->name,
            'timestamp' => $this->message->created_at->diffForHumans(),
            'is_feedback' => $this->message->is_feedback,
        ];
        
        // Include parent message information if this is a reply
        if ($this->message->isReply() && $this->message->parent) {
            $data['parent_id'] = $this->message->parent_id;
            $data['parent_message'] = Str::limit($this->message->parent->message, 50);
            $data['parent_sender_id'] = $this->message->parent->user_id;
            $data['parent_sender_name'] = $this->message->parent->user->name ?? 'Unknown User';
        }
        
        return new BroadcastMessage($data);
    }
}
