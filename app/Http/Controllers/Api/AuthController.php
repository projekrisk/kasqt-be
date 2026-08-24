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
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            
            $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
            $client->setHttpClient($guzzleClient);

            $payload = $client->verifyIdToken($request->id_token);

            if ($payload) {
                $googleId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'];
                $avatarUrl = $payload['picture'] ?? null;

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'google_id' => $googleId,
                        'avatar_url' => $avatarUrl,
                        'role' => 'user',
                    ]
                );

                $token = $user->createToken('android-app-token')->plainTextToken;

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
            Log::error('Google Login Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server saat verifikasi Google.'
            ], 500);
        }
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);
        $request->user()->update(['fcm_token' => $request->token]);

        return response()->json(['success' => true, 'message' => 'FCM Token diperbarui']);
    }

    public function logout(Request $request)
    {
        $request->user()->update(['fcm_token' => null]);
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Berhasil logout'], 200);
    }

    public function updatePhone(Request $request)
    {
        $request->validate(['phone_number' => 'required|string']);
        
        $clean = preg_replace('/[^0-9]/', '', $request->phone_number);
        if (substr($clean, 0, 1) === '0') $clean = '62' . substr($clean, 1);

        $request->user()->update(['phone_number' => $clean]);
        
        return response()->json(['success' => true, 'message' => 'Nomor WA Anda berhasil disimpan!']);
    }

    public function upgradePro(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly'
        ]);
        
        $user = $request->user();
        $now = now();
        
        $baseDate = ($user->pro_expires_at && $user->pro_expires_at->isFuture()) 
                    ? $user->pro_expires_at 
                    : $now;

        if ($request->plan === 'yearly') {
            $user->pro_expires_at = $baseDate->addYears(1);
        } else {
            $user->pro_expires_at = $baseDate->addMonths(1);
        }
        
        $user->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Berhasil upgrade ke paket ' . $request->plan,
            'data' => $user
        ]);
    }
}