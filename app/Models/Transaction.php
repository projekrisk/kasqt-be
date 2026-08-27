<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'creator_id', 'contact_id', 'counterparty_id', 'type', 
        'amount', 'remaining_amount', 'due_date', 'status', 'description', 'token', 'created_at'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function counterparty()
    {
        return $this->belongsTo(User::class, 'counterparty_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function logs()
    {
        return $this->hasMany(TransactionLog::class);
    }
}