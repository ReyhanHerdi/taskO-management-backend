<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class FirebaseController extends Controller
{
    public function sendMessage(Request $request) {
        try {
            $firebase = new FirebaseService();
            $message = [
                'senderId' => (int) $request->sender_id,
                'receiverId' => (int) $request->receiver_id,
                'text' => $request->text,
                'timestamp' => (int) $request->datetime
            ];

            $messageRef = ($request->receiver_id < $request->sender_id) ? $request->receiver_id.'_'.$request->sender_id : $request->sender_id.'_'.$request->receiver_id ;

            $firebase->sendMessage($message, $messageRef);

            $receiver = User::where('id_user', $request->receiver_id)->first();
            $sender = User::where('id_user', $request->sender_id)->first();
            $firebase->pushNotification($receiver->fcm_token, $sender->name, $request->text);

            return response()->json([
                'status' => true,
                'message' => 'Pesan terkirim'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesan gagal terkirim',
                'error' => $th->getMessage()
            ]);
        }
    }
}
