<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function googleLogin(Request $request)
    {
        // 1. Validasi request dari Android memastikan id_token dikirim
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            // 2. Inisialisasi Google Client
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            
            // === TAMBAHKAN 2 BARIS INI UNTUK BYPASS SSL DI LOCALHOST ===
            $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
            $client->setHttpClient($guzzleClient);
            // ============================================================
            
            // 3. Verifikasi token yang dikirim dari Android ke server Google
            $payload = $client->verifyIdToken($request->id_token);

            if ($payload) {
                // 4. Jika valid, ekstrak data user dari payload Google
                $googleId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'];
                $avatarUrl = $payload['picture'] ?? null;

                // 5. Cari atau Buat User baru di database kita
                $user = User::updateOrCreate(
                    ['email' => $email], // Cari berdasarkan email
                    [
                        'name' => $name,
                        'google_id' => $googleId,
                        'avatar_url' => $avatarUrl,
                        'role' => 'user', // Set default role sebagai user aplikasi
                    ]
                );

                // 6. Buat Token Sanctum agar Android bisa mengakses API kita yang diproteksi
                $token = $user->createToken('android-app-token')->plainTextToken;

                // 7. Kembalikan response sukses ke Android
                return response()->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ]
                ], 200);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Google tidak valid.'
                ], 401);
            }

        } catch (\Exception $e) {
            // Log error jika terjadi masalah (misal koneksi ke Google gagal)
            Log::error('Google Login Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server saat verifikasi Google.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Hapus token pengguna saat ini (Logout dari Android)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ], 200);
    }
}