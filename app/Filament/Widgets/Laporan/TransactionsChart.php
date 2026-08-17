<?php

namespace App\Filament\Widgets\Laporan;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class TransactionsChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas Transaksi Pengguna';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $data = [];
        $months = [];
        $currentYear = date('Y');

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->translatedFormat('M');
            $data[] = Transaction::whereYear('created_at', $currentYear)->whereMonth('created_at', $i)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Catatan',
                    'data' => $data,
                    'backgroundColor' => '#F59E0B', // Emas/Amber
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}