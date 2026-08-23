<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 1; 
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->since()
                    ->sortable(),
            ])
            ->paginated(false)
            ->heading('Pengguna Baru');
    }
}