<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $fillable = [
        'transaction_id', 'user_id', 'amount', 'proof_image', 'status'
    ];

    // FITUR BARU: URL Lengkap Gambar agar mudah dibaca oleh Android
    protected $appends = ['proof_image_url'];

    public function getProofImageUrlAttribute()
    {
        return $this->proof_image ? url($this->proof_image) : null;
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}