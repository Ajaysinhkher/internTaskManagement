<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // User side: list all admins
    public function index()
    {

        try{

            $authUser = Auth::user();
    
            // Check guard type or role to decide whether user or admin
            if ($this->isAdmin($authUser)) {
                // ADMIN SIDE: List all users who chatted with this admin
              
                $users = User::all();
                // dd($users->toArray());
                return view('admin.chat.index', compact('users'));
    
            } else {
                // USER SIDE: list all admins
                $admins = Admin::all();
                return view('user.chat.index', compact('admins'));
            }
        }catch(\Exception $e){
            // Handle the exception (e.g., log it, return an error view, etc.)
            return response()->json(['error' => 'An error occurred while fetching chat data.'], 500);
        }
    }

    // Show chat with a specific user or admin based on who is logged in and who is passed
    public function show($chatPartner)
    {

        try{

            $authUser = Auth::user();
    
            if ($this->isAdmin($authUser)) {
                // ADMIN SIDE: $chatPartner is User
                $user = User::findOrFail($chatPartner);
    
                $messages = Message::where(function ($q) use ($authUser, $user) {
                    $q->where('sender_id', $authUser->id)->where('sender_type', get_class($authUser))
                      ->where('receiver_id', $user->id)->where('receiver_type', get_class($user));
                })->orWhere(function ($q) use ($authUser, $user) {
                    $q->where('sender_id', $user->id)->where('sender_type', get_class($user))
                      ->where('receiver_id', $authUser->id)->where('receiver_type', get_class($authUser));
                })->orderBy('created_at')->get();
    
                return view('admin.chat.show', ['user' => $user, 'messages' => $messages]);
    
            } else {
                // USER SIDE: $chatPartner is Admin
                $admin = Admin::findOrFail($chatPartner);
                $user = $authUser;
    
                $messages = Message::where(function ($q) use ($user, $admin) {
                    $q->where('sender_id', $user->id)->where('sender_type', get_class($user))
                      ->where('receiver_id', $admin->id)->where('receiver_type', get_class($admin));
                })->orWhere(function ($q) use ($user, $admin) {
                    $q->where('sender_id', $admin->id)->where('sender_type', get_class($admin))
                      ->where('receiver_id', $user->id)->where('receiver_type', get_class($user));
                })->orderBy('created_at')->get();
    
                return view('user.chat.show', compact('admin', 'messages'));
            }
        }catch(\Exception $e){
            // Handle the exception (e.g., log it, return an error view, etc.)
            return response()->json(['error' => 'An error occurred while fetching chat data.'], 500);
        }
    }

    // Store a message
   public function store(Request $request, $chatPartner)
   {

    try{

        $authUser = Auth::user();
    
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
    
        // Determine the receiver (user or admin)
        $receiver = $this->isAdmin($authUser)
            ? User::findOrFail($chatPartner)
            : Admin::findOrFail($chatPartner);
    
        // Create the message
        $message = Message::create([
            'sender_id' => $authUser->id,
            'sender_type' => get_class($authUser),
            'receiver_id' => $receiver->id,
            'receiver_type' => get_class($receiver),
            'message' => $request->message,
        ]);
    
        Log::info('Message stored chatcontroller', [
            'message_id' => $message->id,
            'sender_id' => $authUser->id,
            'receiver_id' => $receiver->id,
            'sender_type' => get_class($authUser),
            'receiver_type' => get_class($receiver),
            'message' => $request->message,
        ]);

        // Broadcast the message event
        broadcast(new MessageSent($message))->toOthers();
    
        // Return JSON if the request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }
    
        // Fallback redirect (in case of standard POST)
        if ($this->isAdmin($authUser)) {
            return redirect()->route('admin.chat.show', $receiver->id);
        } else {
            return redirect()->route('chat.show', $receiver->id);
        }
    }catch(\Exception $e){
        // Handle the exception (e.g., log it, return an error view, etc.)
        return response()->json(['error' => 'An error occurred while sending the message.'], 500);
    }
}



    // Helper to detect if logged in user is admin or not
    private function isAdmin($user)
    {
        return $user instanceof Admin;
    }
}
