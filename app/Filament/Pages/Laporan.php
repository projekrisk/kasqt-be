<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Laporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Laporan & Statistik';
    protected static ?string $title = 'Laporan Finansial & Sistem';
    
    // File tampilan (dibuat di bawah)
    protected static string $view = 'filament.pages.laporan';

    // Menyusun layout menjadi 2 kolom agar grafik berdampingan
    public function getColumns(): int | string | array
    {
        return 2;
    }

    // Mendaftarkan widget yang HANYA akan muncul di halaman ini
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\UserStatsWidget::class, // Menggunakan widget lama
            \App\Filament\Widgets\Laporan\FinancialStatsWidget::class,
            \App\Filament\Widgets\Laporan\UsersChart::class,
            \App\Filament\Widgets\Laporan\TransactionsChart::class,
            \App\Filament\Widgets\Laporan\ProUsersTableWidget::class,
        ];
    }
}