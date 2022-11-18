<?php

namespace App\Services;

use App\Libs\Firebase\PushNotification;

class FirebaseService
{
    public function pushMessageAdmin(string $title)
    {
        $pushNotificationService = new PushNotification();
        $data = ['func_name' => 'Push-Notification'];
        $notification = [
            "title" => 'Haki',
            "body" => $title,
            'badge' => 1,
            'sound' => 'default'
        ];

        return $pushNotificationService->send(config('firebase.device_token'), $notification, $data);
    }
}
