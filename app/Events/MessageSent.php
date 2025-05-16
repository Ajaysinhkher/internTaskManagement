<?php
namespace App\Events;

use App\Models\Message;
// use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {

          Log::info('MessageSent event constructed', [
            'message_id' => $message->id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
        ]);

        $this->message = $message->load('sender', 'receiver');
       
    }

    public function broadcastOn() : Channel
    {
        // Order the sender and receiver IDs to make the channel name consistent
        $senderId = $this->message->sender_id;
        $receiverId = $this->message->receiver_id;

        // Always order the IDs to ensure the channel name is the same for both sides
        $channelName = 'chat.' . min($senderId, $receiverId) . '.' . max($senderId, $receiverId);

        Log::info('Broadcasting on channel', ['channel' => $channelName]);

        return new Channel($channelName);
    }

    public function broadcastWith()
    {
        Log::info('Broadcasting with message data', [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
        ]);
        
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'sender_type' => class_basename($this->message->sender_type),
            'receiver_id' => $this->message->receiver_id,
            'receiver_type' => $this->message->receiver_type,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
