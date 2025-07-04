<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Trainings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static string $view = 'filament.pages.trainings';
    protected static ?string $navigationGroup = 'Other';
    protected static ?int $navigationSort = 100000;

    public function getTitle(): string
    {
        return '';
    }
}
