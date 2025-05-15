<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{type}.{id}', function ($user, $type, $id) {
    Log::info('Broadcast channel check', [
        'user_id' => $user->id,
        'type' => $type,
        'id' => $id,
    ]);
    
    Log::info( (int) $user->id === (int) $id &&
           strtolower(class_basename(get_class($user))) === strtolower($type));

    return (int) $user->id === (int) $id &&
           strtolower(class_basename(get_class($user))) === strtolower($type);
});
