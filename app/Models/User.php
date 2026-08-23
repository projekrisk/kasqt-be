<?php
namespace App\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone_number', 'google_id', 'avatar_url', 'password', 'role', 'fcm_token', 'pro_expires_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'is_pro'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'pro_expires_at' => 'datetime',
        ];
    }

    public function getIsProAttribute(): bool
    {
        return $this->pro_expires_at !== null && $this->pro_expires_at->isFuture();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function transactionsCreated()
    {
        return $this->hasMany(Transaction::class, 'creator_id');
    }
}