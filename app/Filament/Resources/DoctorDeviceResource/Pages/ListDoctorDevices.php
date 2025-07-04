<?php

namespace App\Filament\Resources\DoctorDeviceResource\Pages;

use App\Filament\Resources\DoctorDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorDevices extends ListRecords
{
    protected static string $resource = DoctorDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
