<?php

namespace App\Events;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class MessageRead implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $conversationId,
        public int $readerId,
        public int $receiverId,


    ) {
        Log::info('📡 MessageSent Read triggered!',
            [
                'conversation_id' => $conversationId,
                'time' => now(),
            ]);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("conversation.{$this->receiverId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'messages.read';
    }
}
