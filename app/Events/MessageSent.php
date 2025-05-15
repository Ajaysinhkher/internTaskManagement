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

    public function broadcastOn()
    {
        
        Log::info('Broadcasting on channel', [
            'channel' => 'chat.' . class_basename($this->message->receiver_type) . '.' . $this->message->receiver_id,
        ]);

        // Determine the channel based on the receiver type and ID
       return new Channel('chat.' . class_basename($this->message->receiver_type) . '.' . $this->message->receiver_id);
        
    }

    public function broadcastWith()
    {

        log::info('Broadcasting with message data', [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
        ]);
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'sender_type' => $this->message->sender_type,
            'receiver_id' => $this->message->receiver_id,
            'receiver_type' => $this->message->receiver_type,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
