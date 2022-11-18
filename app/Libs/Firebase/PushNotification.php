<?php

namespace App\Libs\Firebase;

use GuzzleHttp\Client;

class PushNotification
{
    private $apiConfig;

    public function __construct()
    {
        $this->apiConfig = [
            'url' => config('firebase.push_url'),
            'server_key' => config('firebase.server_key')
        ];
    }

    /**
     * Sending push message to single user by Firebase
     *
     * @param string $device_token
     * @param array $notification
     * @param array $data
     *
     * @return bool|string
     */
    
    public function send(string $device_token, array $notification, array $data)
    {
        $fields = [
            'to'   => $device_token,
            'notification' => $notification,
            'data' => $data
        ];

        return $this->sendPushNotification($fields);
    }

    /**
     * Sending push message to multiple users by firebase
     * @param array $device_tokens
     * @param array $notification
     * @param array $data
     *
     * @return bool|string
     */
    public function sendMultiple(array $device_tokens, array $notification, array $data)
    {
        $fields = [
            'registration_ids' => $device_tokens,
            'data' => $data,
            'notification' => $notification
        ];

        return $this->sendPushNotification($fields);
    }

    /**
     * GuzzleHTTP request to firebase servers
     * @param array $fields
     *
     * @return bool
     */
    private function sendPushNotification(array $fields)
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'key='. $this->apiConfig['server_key'],
            ]
        ]);
                
        $res = $client->post(
            $this->apiConfig['url'],
            ['body' => json_encode($fields)]
        );

        $res = json_decode($res->getBody());
    
        if ($res->failure) {
            \Log::error("ERROR_PUSH_NOTIFICATION: ". json_encode($fields));
        }

        return true;
    }
}
