<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProUsersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->whereNotNull('pro_expires_at')->where('pro_expires_at', '>', now())->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\IconColumn::make('is_pro')
                    ->label('Status')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => $record->is_pro)
                    ->trueIcon('heroicon-o-check-badge'), 
            ])
            ->paginated(false)
            ->heading('Pengguna PRO Terbaru');
    }
}