<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService {

    protected $messaging;
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_REALTIME_DB'));

        $this->messaging = $factory->createMessaging();
        $this->database = $factory->createDatabase();

    }

    public function sendMessage($data, $messageRef) {
        return $this->database->getReference($messageRef)->push($data);
    }

    public function pushNotification($token, $title, $body) {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body));

        return $this->messaging->send($message);
    }
}
