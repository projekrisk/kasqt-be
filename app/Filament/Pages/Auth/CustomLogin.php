<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class CustomLogin extends BaseLogin
{
    // Mengarahkan ke file kotak form (Langkah 2)
    protected static string $view = 'filament.pages.auth.custom-login';

    // Mengganti layout bawaan Filament dengan layout custom (Langkah 1)
    public function getLayout(): string
    {
        return 'layouts.custom-login-layout';
    }
}