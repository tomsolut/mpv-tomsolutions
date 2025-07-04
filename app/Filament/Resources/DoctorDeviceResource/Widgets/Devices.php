<?php

namespace App\Filament\Resources\DoctorDeviceResource\Widgets;

use App\Enums\RolesEnum;
use App\Filament\Resources\DoctorDeviceResource;
use App\Models\DoctorDevice;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Devices extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\DoctorDevice::query()
                    ->with(['device', 'room.location.doctor', 'device.manufacturer', 'device.deviceType'])
                    ->when(!auth()->user()->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]), function ($query) {
                        $query->whereHas('room.location', function ($query) {
                            $query->where('user_id', auth()->id());
                        });
                    }))
            ->recordClasses(function (DoctorDevice $doctorDevice) {
                $recallDate = $doctorDevice->last_certification_date->addDays($doctorDevice->device->recall_period);
                $monthsDiff = now()->diffInMonths($recallDate);

                if ($monthsDiff < 1) {
                    return 'certification-danger';
                } elseif ($monthsDiff < 2) {
                    return 'certification-warning';
                } else {
                    return 'certification-success';
                }
            })
                    ->columns([
                        TextColumn::make('name')
                            ->searchable()
                            ->label('Name'),
                        TextColumn::make('serial_number')
                            ->searchable()
                            ->label('Serial Number'),
                        TextColumn::make('device.name')
                            ->searchable()
                            ->label('Device'),
                        TextColumn::make('room.location.doctor.name')
                            ->searchable()
                            ->label('Doctor'),
                        TextColumn::make('device.manufacturer.name')
                            ->searchable()
                            ->label('Manufacturer'),
                        TextColumn::make('device.deviceType.name')
                            ->searchable()
                            ->label('Device Type'),
                        TextColumn::make('room.name')
                            ->searchable()
                            ->label('Room'),
                        TextColumn::make('last_certification_date')
                            ->date()
                            ->searchable()
                            ->label('Last Certification Date'),
                    ])
                    ->actions([
                        Tables\Actions\EditAction::make()
                            ->label('Edit')
                            ->url(fn($record) => DoctorDeviceResource::getUrl('edit', ['record' => $record])),
                        Tables\Actions\DeleteAction::make()
                    ]);
    }
}
