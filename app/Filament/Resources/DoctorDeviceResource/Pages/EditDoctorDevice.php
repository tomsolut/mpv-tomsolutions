<?php

namespace App\Filament\Resources\DoctorDeviceResource\Pages;

use App\Filament\Resources\DoctorDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorDevice extends EditRecord
{
    protected static string $resource = DoctorDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
