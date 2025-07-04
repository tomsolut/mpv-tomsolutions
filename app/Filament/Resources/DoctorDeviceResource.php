<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Filament\Resources\DoctorDeviceResource\Pages;
use App\Filament\Resources\DoctorDeviceResource\RelationManagers;
use App\Models\DoctorDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;

class DoctorDeviceResource extends Resource
{
    protected static ?string $model = DoctorDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('serial_number')
                    ->label('Serial Number'),
                Select::make('device_id')
                    ->relationship('device', 'name')
                    ->label('Device')
                    ->required(),
                Select::make('room_id')
                    ->relationship('room', 'name')
                    ->label('Room')
                    ->required(),
                DatePicker::make('last_certification_date')
                    ->label('Last Certification Date'),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        $filters = [
            Tables\Filters\SelectFilter::make('room.location_id')
                ->relationship('room.location', 'name')
                ->label('Location'),
            Tables\Filters\SelectFilter::make('room_id')
                ->relationship('room', 'name')
                ->label('Room'),
            Tables\Filters\SelectFilter::make('device_id')
                ->relationship('device', 'name')
                ->label('Device'),
            Tables\Filters\SelectFilter::make('device.deviceType_id')
                ->relationship('device.deviceType', 'name')
                ->label('Device Type'),
            Tables\Filters\SelectFilter::make('device.manufacturer_id')
                ->relationship('device.manufacturer', 'name')
                ->label('Manufacturer'),
        ];

        if (auth()->user()->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN])) {
            Tables\Filters\SelectFilter::make('room.location.user_id')
                ->relationship('room.location.doctor', 'name')
                ->label('Doctor');
        }

        return $table
            ->recordClasses(function (DoctorDevice $doctorDevice) {
                $recallDate = $doctorDevice->last_certification_date->addDays($doctorDevice->device->recall_period);
                $monthsDiff = now()->diffInWeeks($recallDate);

                if ($monthsDiff < 6) {
                    return 'certification-danger';
                } elseif ($monthsDiff < 12) {
                    return 'certification-warning';
                } else {
                    return 'certification-success';
                }
            })
            ->modifyQueryUsing(function (Builder $query) { if (!auth()->user()->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN])) {
                $query->whereHas('room.location', function (Builder $query) {
                    $query->where('user_id', auth()->id());
                });
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
                TextColumn::make('notes')
                    ->label('Notes')
                    ->searchable()
                    ->extraAttributes(['style' => 'width: 400px'])
                    ->wrap()
            ])
            ->filters($filters)
            ->actions([
                Tables\Actions\Action::make('attachments')
                    ->color('warning')
                    ->label('Attachments')
                    ->icon('heroicon-o-paper-clip')
                    ->url(fn($record) => AttachmentResource::getUrl('index', ['doctorDevice' => $record->id]))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctorDevices::route('/'),
            'create' => Pages\CreateDoctorDevice::route('/create'),
            'edit' => Pages\EditDoctorDevice::route('/{record}/edit'),
        ];
    }
}
