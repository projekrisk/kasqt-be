<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsersWidget extends BaseWidget
{
    // Mengambil 1 slot (setengah layar) agar widget bisa berdampingan
    protected int | string | array $columnSpan = 1; 
    protected static ?int $sort = 2; // Urutan tampilan di dashboard

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->latest()->limit(5) // Ambil 5 terbaru
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->since() // Menampilkan "2 jam yang lalu"
                    ->sortable(),
            ])
            ->paginated(false) // Hilangkan pagination karena kita melimitasi 5 data
            ->heading('👥 5 Pengguna Baru');
    }
}