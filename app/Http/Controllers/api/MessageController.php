<?php

namespace App\Http\Controllers\api;

use App\Helper\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function getMessage($id) {
        try {
            $message = Message::query()
            ->leftJoin('users', 'messages.user_id', '=', 'users.id_user')
            ->leftJoin('users as users2', 'messages.user2_id', '=', 'users2.id_user')
            ->select('messages.*', 'users.name', 'users2.name as name_2', 'users.photoUrl', 'users2.photoUrl as photoUrl_2')
            ->where('user_id', $id)
            ->orWhere('user2_id', $id)
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diambil',
                'data' => $message
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diambil',
                'data' => $th->getMessage()
            ]);
        }
    }

    public function setUserIdAndUser2Id($user_id, $user2_id) : array {
        if ($user_id < $user2_id) {
            return [
                'user_id' => $user_id,
                'user2_id' => $user2_id
            ];
        } else {
            return [
                'user_id' => $user2_id,
                'user2_id' => $user_id
            ];
        }
    }


    public function storeMessage(Request $request) {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'message_id' => 'required',
                'team_id' => 'required',
                'user_id' => 'required',
                'user2_id' => 'required',
                'message' => 'nullable'
            ]);

            if ($validator->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data belum lengkap'
                ]);
            }

            $setUserIdAndUser2Id = $this->setUserIdAndUser2Id($request->user_id, $request->user2_id);

            $user = User::where('id_user', $request->user_id)->first();
            PushNotificationHelper::sendPushNotification($request->user2_id, $user->name, $request->message);
            $message = Message::where('id_message', $request->message_id)->first();
            if ($message) {
                Message::where('id_message', $request->message_id)->update([
                    'last_message' => $request->message
                ]);
            } else {
                Message::create([
                    'id_message' => $request->message_id,
                    'team_id' => $request->team_id,
                    'user_id' => $setUserIdAndUser2Id['user_id'],
                    'user2_id' => $setUserIdAndUser2Id['user2_id'],
                    'last_message' => $request->message
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dibuat',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dibuat',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function updateMessage($id, Request $request) {
        try {
            Message::where('id_message', $id)->update([
                'last_message' => $request->message
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diubah',
                'error' => $th->getMessage()
            ]);
        }
    }
}
