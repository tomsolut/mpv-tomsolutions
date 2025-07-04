<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Other';

    public static function getNavigationLabel(): string
    {
        return auth()->user()->hasRole([RolesEnum::DOCTOR->value]) ? 'Users (Employees)' : 'Users';
    }

    public static function form(Form $form): Form
    {
        $formSchema = [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->required()
                ->maxLength(255)
                ->email()
                ->unique(ignoreRecord: true),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $context) => $context === 'create'),
        ];

        if (auth()->user()->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN])) {
            $formSchema = array_merge($formSchema, [
                Select::make('role')
                    ->selectablePlaceholder(false)
                    ->relationship('roles', 'name')
                    ->required()
                    ->options(function () {
                        // Retrieve roles excluding the current user's role when necessary
                        return Role::query()
                            ->when(auth()->check() && auth()->user()->hasRole(RolesEnum::SUPER_ADMIN->value), fn($query) => $query->whereNotIn('name', [RolesEnum::SUPER_ADMIN->value]))
                            ->when(auth()->check() && auth()->user()->hasRole(RolesEnum::ADMIN->value), fn($query) => $query->whereNotIn('name', [RolesEnum::SUPER_ADMIN->value, RolesEnum::ADMIN->value]))
                            ->pluck('name', 'id');
                    })
                    ->disabled(fn(string $context) => $context === 'edit')  // Disable on edit
                    ->live(),

                Select::make('user_id')
                    ->relationship('employer', 'name')
                    ->options(fn() => User::where('id', '!=', auth()->id())
                        ->whereHas('roles', fn($query) => $query->whereIn('name', [RolesEnum::DOCTOR->value]))
                        ->pluck('name', 'id')
                    )
                    ->required()
                    ->hidden(fn($get) => !Role::where('id', $get('role'))->where('name', RolesEnum::EMPLOYEE->value)->exists())
            ]);
        } elseif (auth()->user()->hasRole(RolesEnum::DOCTOR)) {
            $formSchema = array_merge($formSchema, [
                Forms\Components\Hidden::make('role')->default(Role::where('name', RolesEnum::EMPLOYEE->value)->first()->id),
                Forms\Components\Hidden::make('user_id')->default(auth()->id()),
            ]);
        }

        return $form
            ->schema($formSchema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->hasRole(RolesEnum::SUPER_ADMIN)) {
                    $query->whereHas('roles', fn($query) => $query->whereNotIn('name', [RolesEnum::SUPER_ADMIN]));
                } elseif (auth()->user()->hasRole(RolesEnum::ADMIN)) {
                    $query->whereHas('roles', fn($query) => $query->whereNotIn('name', [RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]));
                } elseif (auth()->user()->hasRole(RolesEnum::DOCTOR)) {
                    $query->whereHas('roles', fn($query) => $query->whereIn('name', [RolesEnum::EMPLOYEE]));
                    $query->whereHas('employer', fn($query) => $query->where('id', auth()->id()));
                }
                $query->where('id', '!=', auth()->id());
                $query->with('roles');
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Role')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('locations')
                    ->color('warning')
                    ->label('Locations')
                    ->icon('heroicon-o-map-pin')
                    ->url(fn($record) => LocationResource::getUrl('index', ['tableFilters[user_id][value]' => $record->id]))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('devices')
                    ->color('danger')
                    ->label('Devices')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url(fn($record) => DoctorDeviceResource::getUrl('index', ['tableFilters[room][location][user_id][value]' => $record->id]))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
