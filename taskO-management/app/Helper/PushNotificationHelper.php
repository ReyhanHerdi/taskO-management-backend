<?php

namespace App\Helper;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class PushNotificationHelper {
    public static function sendPushNotification($receiver, $title, $message) {
        try {
            $firebase = new FirebaseService();

            $receiver = User::where('id_user', $receiver)->first();
            $firebase->pushNotification($receiver->fcm_token, $title, $message);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}