<?php
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessagesRead implements ShouldBroadcast
{
    public function __construct(
        public int $conversationId,
        public int $readerId,
        public array $messageIds
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'conversation.' . $this->conversationId
            )
        ];
    }

    public function broadcastAs(): string
    {
        return 'messages.read';
    }
}
