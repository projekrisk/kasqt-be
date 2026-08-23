<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public static function sendNotification($fcmToken, $title, $body, $transactionId = null)
    {
        if (empty($fcmToken)) {
            return false;
        }

        try {
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('firebase-credentials.json'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            
            $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
            $client->setHttpClient($guzzleClient);
            
            $client->fetchAccessTokenWithAssertion();
            $accessToken = $client->getAccessToken()['access_token'];

            $projectId = env('FIREBASE_PROJECT_ID'); 
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            
            $payload = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body
                    ],
                    'data' => []
                ]
            ];

            if ($transactionId) {
                $payload['message']['data']['transaction_id'] = (string) $transactionId;
            }

            $response = Http::withOptions(['verify' => false])
                ->withToken($accessToken)
                ->post($url, $payload);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Gagal Mengirim FCM: ' . $e->getMessage());
            return false;
        }
    }
}