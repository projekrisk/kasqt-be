<?php

namespace App\Filament\Widgets\Laporan;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProUsersTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Pengguna PRO Aktif';
    protected static bool $isDiscovered = false;
        
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(User::whereNotNull('pro_expires_at')->where('pro_expires_at', '>', now())->latest())
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(url('https://ui-avatars.com/api/?name=PRO&color=7F9CF5&background=EBF4FF')),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. WA')
                    ->default('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung Pada')
                    ->date(),
            ]);
    }
}