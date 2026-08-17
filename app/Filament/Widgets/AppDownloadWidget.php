<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AppDownloadWidget extends Widget
{
    protected static string $view = 'filament.widgets.app-download-widget';
    
    protected static ?int $sort = -2;
}