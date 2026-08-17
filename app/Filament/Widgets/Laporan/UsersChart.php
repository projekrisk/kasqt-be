<?php

namespace App\Filament\Widgets\Laporan;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Pendaftaran Pengguna Baru';
    protected static bool $isDiscovered = false;

    protected function getData(): array
    {
        $data = [];
        $months = [];
        $currentYear = date('Y');

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->translatedFormat('M');
            $data[] = User::whereYear('created_at', $currentYear)->whereMonth('created_at', $i)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)', // Hijau Transparan
                    'borderColor' => '#10B981', // Hijau Kasqt
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}