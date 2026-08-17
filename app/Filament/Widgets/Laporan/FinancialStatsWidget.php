<?php

namespace App\Filament\Widgets\Laporan;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialStatsWidget extends BaseWidget
{
    // Cegah muncul di Dasbor Utama
    protected static bool $isDiscovered = false;

    // Memakan 2 kolom penuh
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPro = User::where('is_pro', true)->count();
        
        // ALGORITMA SIMULASI: Anggap 70% pengguna memilih paket Tahunan
        $proTahunan = (int) ceil($totalPro * 0.7);
        $proBulanan = $totalPro - $proTahunan;
        
        // Kalkulasi Pendapatan Kotor
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