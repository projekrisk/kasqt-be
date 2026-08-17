<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AppDownloadWidget extends Widget
{
    // Menggunakan tampilan khusus (blade)
    protected static string $view = 'filament.widgets.app-download-widget';
    
    // UBAH ANGKA INI MENJADI NEGATIF
    // Agar tampil tepat di sebelah Account Widget (Selamat Datang) dan sebelum Statistik
    protected static ?int $sort = -2;
}