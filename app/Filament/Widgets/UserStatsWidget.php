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
                
            Stat::make('Pengguna PRO', User::where('is_pro', true)->count())
                ->description('Membayar langganan')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
                
            Stat::make('Pengguna Gratis', User::where('is_pro', false)->count())
                ->description('Belum berlangganan')
                ->color('gray'),
        ];
    }
}