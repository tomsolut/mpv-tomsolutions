<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Filament\Resources\AttachmentResource\Pages;
use App\Filament\Resources\AttachmentResource\RelationManagers;
use App\Models\Attachment;
use App\Models\DoctorDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        $doctorDeviceId = request('doctorDevice');

        if (!is_numeric($doctorDeviceId)) {
            session()->forget('doctorDevice');
            return false;
        }

        session()->put('doctorDevice', $doctorDeviceId);

        if (auth()->user()->hasRole([RolesEnum::DOCTOR])) {
            return DoctorDevice::where('id', $doctorDeviceId)
                ->whereHas('room.location', function (Builder $query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->exists();
        } else {
            return true;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Attachment Name')
                    ->required(),

                Forms\Components\FileUpload::make('file')
                    ->label('File Upload')
                    ->required()
                    ->preserveFilenames()
                    ->directory('attachments')
                    ->disk('local'),
                Forms\Components\Hidden::make('doctor_device_id')
                    ->default(session('doctorDevice'))
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (session('doctorDevice')) {
                    $query->where('doctor_device_id', session('doctorDevice'));
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Attachment Name')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->color('warning')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Attachment $record) {
                        return response()->download(
                            storage_path('app/private/' . $record->file),
                        );
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachments::route('/'),
        ];
    }
}
