<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Log::info('Broadcast channel registration started');
// // Log::info('sender_id: '. $sender_id . ' receiverId:' . $receiver_id);
// Broadcast::channel('chat.{sender_id}.{receiver_id}', function ($user, $sender_id, $receiver_id) {
//     Log::info('Broadcast channel check', [
//         'user_id' => $user->id,
//         'type' => $type,
//         'id' => $id,
//     ]);

//     return true;// (int) $user->id === (int) $id && strtolower(class_basename(get_class($user))) === strtolower($type);
// });

Broadcast::channel('chat.{sender_id}.{receiver_id}', function ($user, $sender_id, $receiver_id) {
    // You might need to add a condition to check if the user is either the sender or the receiver
    return true; //$user->id == $sender_id || $user->id == $receiver_id;
});