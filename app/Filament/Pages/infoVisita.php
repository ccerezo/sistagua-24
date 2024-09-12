<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class infoVisita extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.info-visita';

    protected static bool $shouldRegisterNavigation = false;
}
