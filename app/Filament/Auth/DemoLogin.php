<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login;

class DemoLogin extends Login
{
    public function getSubheading(): ?string
    {
        return null;
    }
}
