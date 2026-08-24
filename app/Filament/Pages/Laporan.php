<?php
namespace App\Filament\Pages;
use Filament\Pages\Page;
class Laporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $title = 'Laporan';
    protected static string $view = 'filament.pages.laporan';

    public function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\UserStatsWidget::class,
            \App\Filament\Widgets\Laporan\FinancialStatsWidget::class,
            \App\Filament\Widgets\Laporan\UsersChart::class,
            \App\Filament\Widgets\Laporan\TransactionsChart::class,
            // App\Filament\Widgets\Laporan\ProUsersTableWidget::class,
        ];
    }
}