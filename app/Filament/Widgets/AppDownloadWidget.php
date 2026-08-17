<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AppDownloadWidget extends Widget
{
    // Menggunakan tampilan khusus (blade)
    protected static string $view = 'filament.widgets.app-download-widget';
    
    // Urutan ke-2 (Setelah Widget Statistik User)
    protected static ?int $sort = 2;
}