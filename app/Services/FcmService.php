<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public static function sendNotification($token, $title, $body)
    {
        if (!$token) return false;

        try {
            // 1. Baca Kunci Master (File JSON)
            $credentialsFilePath = storage_path('firebase-credentials.json');
            if (!file_exists($credentialsFilePath)) {
                Log::error('FCM Error: File firebase-credentials.json tidak ditemukan di folder storage.');
                return false;
            }

            $credentials = json_decode(file_get_contents($credentialsFilePath), true);
            $projectId = $credentials['project_id'];
            $clientEmail = $credentials['client_email'];
            $privateKey = $credentials['private_key'];

            // 2. Buat Tanda Tangan Keamanan (JWT) Otomatis Tanpa Library Eksternal
            $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
            $now = time();
            $payload = json_encode([
                'iss' => $clientEmail,
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'exp' => $now + 3600,
                'iat' => $now
            ]);

            $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
            $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

            openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

            // 3. Tukar Tanda Tangan dengan Tiket Akses Google
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('FCM Token Error: ' . $tokenResponse->body());
                return false;
            }

            $accessToken = $tokenResponse->json('access_token');

            // 4. Kirim Notifikasi ke HP Pengguna (HTTP v1 API Terbaru)
            $fcmUrl = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            $messageData = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body
                    ],
                    'data' => [ // Data tambahan agar penangkap di Android bekerja
                        'title' => $title,
                        'body' => $body
                    ]
                ]
            ];

            // 5. Eksekusi Pengiriman
            $response = Http::withToken($accessToken)->post($fcmUrl, $messageData);
            return $response->successful();

        } catch (\Exception $e) {
            Log::error('FCM Send Error: ' . $e->getMessage());
            return false;
        }
    }
}