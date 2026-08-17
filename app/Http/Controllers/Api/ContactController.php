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

        $existingContact = Contact::where('user_id', $request->user()->id)
            ->where('phone_number', $request->phone_number)
            ->first();

        if ($existingContact) {
            return response()->json([
                'success' => false,
                'message' => "Nomor ini sudah disimpan sebagai kontak bernama '{$existingContact->name}'."
            ], 409); 
        }

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

        $existingContact = Contact::where('user_id', $request->user()->id)
            ->where('phone_number', $request->phone_number)
            ->where('id', '!=', $id)
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

        return response()->json(['success' => true, 'message' => 'Kontak berhasil diperbarui', 'data' => $contact]);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Kontak tidak ditemukan.'], 404);
        }

        $contact->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil dihapus.'
        ]);
    }

    public function syncPhonebook(Request $request)
    {
        $request->validate(['phone_numbers' => 'required|array']);
        $userId = $request->user()->id;

        $normalizedNumbers = [];
        foreach ($request->phone_numbers as $phone) {
            $clean = preg_replace('/[^0-9]/', '', $phone);
            if (substr($clean, 0, 1) === '0') $clean = '62' . substr($clean, 1);
            if (!empty($clean)) $normalizedNumbers[] = $clean;
        }

        $matchedUsers = \App\Models\User::whereIn('phone_number', array_unique($normalizedNumbers))
                            ->where('id', '!=', $userId)
                            ->get();

        $addedCount = 0;
        foreach ($matchedUsers as $match) {
            $exists = Contact::where('user_id', $userId)->where('phone_number', $match->phone_number)->first();
            
            if (!$exists) {
                Contact::create([
                    'user_id' => $userId,
                    'name' => $match->name, 
                    'phone_number' => $match->phone_number,
                    'is_kasqt_user' => true,
                ]);
                $addedCount++;
            } else {
                $exists->update(['is_kasqt_user' => true, 'name' => $match->name]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $addedCount . ' Teman Kasqt berhasil ditemukan & disinkronkan!'
        ]);
    }
}