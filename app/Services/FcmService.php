<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * Fungsi untuk menembakkan Push Notification ke HP Android
     */
    public static function sendNotification($fcmToken, $title, $body, $transactionId = null)
    {
        // Jika user belum pernah login di Android, batalkan pengiriman
        if (empty($fcmToken)) {
            return false;
        }

        try {
            // 1. Inisialisasi Google Client menggunakan file kredensial rahasia Firebase
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('firebase-credentials.json'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            
            // Bypass SSL untuk localhost (Sama seperti saat Login Google)
            $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
            $client->setHttpClient($guzzleClient);
            
            // 2. Dapatkan Token Akses Otentikasi (Berlaku 1 jam)
            $client->fetchAccessTokenWithAssertion();
            $accessToken = $client->getAccessToken()['access_token'];

            // 3. Siapkan URL API Firebase v1
            $projectId = env('FIREBASE_PROJECT_ID'); 
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            
            // 4. Rakit Pesan (Judul, Isi, dan Data ID Transaksi)
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

            // Sisipkan ID Transaksi agar notifikasi bisa diklik dari Android
            if ($transactionId) {
                $payload['message']['data']['transaction_id'] = (string) $transactionId;
            }

            // 5. Tembakkan ke Google Server!
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