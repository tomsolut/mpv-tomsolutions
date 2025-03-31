<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('doctor', 'name')
                    ->label('Doctor')
                    ->required(),

                TextInput::make('city')
                    ->label('City'),
                TextInput::make('postal_code')
                    ->label('Postal Code'),
                TextInput::make('street1')
                    ->label('Street 1'),
                TextInput::make('street2')
                    ->label('Street 2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('city')
                    ->searchable()
                    ->label('City'),
                TextColumn::make('postal_code')
                    ->searchable()
                    ->label('Postal Code'),
                TextColumn::make('street1')
                    ->searchable()
                    ->label('Street 1'),
                TextColumn::make('street2')
                    ->searchable()
                    ->label('Street 2'),
                TextColumn::make('doctor.name')
                    ->badge()
                    ->searchable()
                    ->label('Doctor'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
