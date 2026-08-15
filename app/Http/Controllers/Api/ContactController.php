<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::where('user_id', $request->user()->id)->get();
        
        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap.',
            ], 422);
        }

        // 2. Pengecekan Nomor Telepon Ganda (Untuk User Ini)
        $existingContact = Contact::where('user_id', $request->user()->id)
            ->where('phone_number', $request->phone_number)
            ->first();

        if ($existingContact) {
            // Jika sudah ada, tolak dan kembalikan pesan error kustom
            return response()->json([
                'success' => false,
                'message' => "Nomor ini sudah disimpan sebagai kontak bernama '{$existingContact->name}'."
            ], 409); 
        }

        // 3. Simpan jika aman
        $contact = Contact::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'is_kasqt_user' => false, 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil ditambahkan',
            'data' => $contact
        ], 201);
    }

    // FUNGSI BARU: Edit Kontak
    public function update(Request $request, $id)
    {
        $contact = Contact::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Kontak tidak ditemukan.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Cek apakah nomor yang baru ini sudah dipakai oleh kontak LAIN milik user ini
        $existingContact = Contact::where('user_id', $request->user()->id)
            ->where('phone_number', $request->phone_number)
            ->where('id', '!=', $id) // Abaikan ID kontak yang sedang diedit ini
            ->first();

        if ($existingContact) {
            return response()->json([
                'success' => false,
                'message' => "Nomor ini sudah dipakai oleh kontak bernama '{$existingContact->name}'."
            ], 409);
        }

        $contact->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil diperbarui',
            'data' => $contact
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Kontak tidak ditemukan.'], 404);
        }

        // Transaksi lama TIDAK akan terhapus karena 'nullOnDelete()' di database.
        $contact->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil dihapus.'
        ]);
    }
}