<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaksi', Transaction::count())
                ->description('Seluruh transaksi tercatat')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
                
            Stat::make('Total Tagihan Aktif', 'Rp ' . number_format(Transaction::where('type', 'piutang')->where('status', '!=', 'PAID')->sum('remaining_amount'), 0, ',', '.'))
                ->description('Dana masuk yang ditunggu')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),
                
            Stat::make('Total Kewajiban Aktif', 'Rp ' . number_format(Transaction::where('type', 'hutang')->where('status', '!=', 'PAID')->sum('remaining_amount'), 0, ',', '.'))
                ->description('Dana keluar tertunda')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
        ];
    }
}