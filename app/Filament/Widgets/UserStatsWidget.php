<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Seluruh user terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Pengguna PRO', User::whereNotNull('pro_expires_at')->where('pro_expires_at', '>', now())->count())
                ->description('Membayar langganan')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Grafik simulasi naik-turun
                
            Stat::make('Pengguna Gratis', User::where(function ($query) {
                $query->whereNull('pro_expires_at')->orWhere('pro_expires_at', '<=', now());
            })->count())
                ->description('Belum berlangganan')
                ->color('gray'),
        ];
    }
}