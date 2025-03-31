<?php

namespace App\Filament\Resources;

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
use Filament\Forms\Components\Datepicker;
use Filament\Tables\Columns\TextColumn;

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
                Datepicker::make('last_certification_date')
                    ->label('Last Certification Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                TextColumn::make('room.name')
                    ->searchable()
                    ->label('Room'),
                TextColumn::make('last_certification_date')
                    ->searchable()
                    ->label('Last Certification Date'),
            ])
            ->actions([
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
