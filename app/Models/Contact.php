<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = ['user_id', 'name', 'phone_number', 'is_kasqt_user'];

    // FITUR BARU: Memaksa MySQL menerjemahkan 0/1 menjadi true/false untuk Android
    protected function casts(): array
    {
        return [
            'is_kasqt_user' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}