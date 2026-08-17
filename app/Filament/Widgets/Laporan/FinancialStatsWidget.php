<?php

namespace App\Filament\Widgets\Laporan;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialStatsWidget extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPro = User::where('is_pro', true)->count();
        
        $proTahunan = (int) ceil($totalPro * 0.7);
        $proBulanan = $totalPro - $proTahunan;
        
        $pendapatan = ($proTahunan * 99000) + ($proBulanan * 15000);

        return [
            Stat::make('Pelanggan PRO Tahunan', $proTahunan)
                ->description('Estimasi (70% dari Total PRO)')
                ->color('success'),
                
            Stat::make('Pelanggan PRO Bulanan', $proBulanan)
                ->description('Estimasi (30% dari Total PRO)')
                ->color('info'),
                
            Stat::make('Total Pendapatan (Gross)', 'Rp ' . number_format($pendapatan, 0, ',', '.'))
                ->description('Simulasi Pendapatan Kasqt')
                ->color('warning')
                ->descriptionIcon('heroicon-m-banknotes'),
        ];
    }
}