<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('Message-Channel.{id}', function ($user, $id) {
    Log::info('Channel auth attempt', ['user_id' => $user?->id, 'channel_id' => $id]);
    return $user && (int) $user->id === (int) $id;
});



Broadcast::channel('conversation.{id}', function ($user, $id) {

    Log::info('Conversation channel auth', [
        'user_id' => $user?->id,
        'conversation_id' => $id,
    ]);

    return true;
});

