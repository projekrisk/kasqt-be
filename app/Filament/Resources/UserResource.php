<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $slug = 'pengguna';    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Peran (Role)')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User Aplikasi',
                    ])
                    ->required()
                    ->default('user'),
                Forms\Components\DateTimePicker::make('pro_expires_at')
                    ->label('Batas Aktif PRO')
                    ->placeholder('Kosongkan jika pengguna gratis'),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(url('https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF')),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_pro')
                    ->label('PRO')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => $record->is_pro)
                    ->trueIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('pro_expires_at')
                    ->label('Masa Aktif')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Peran')
                    ->colors([
                        'primary' => 'user',
                        'success' => 'admin',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_pro')
                    ->label('Status Langganan')
                    ->placeholder('Semua Pengguna')
                    ->trueLabel('Pengguna PRO')
                    ->falseLabel('Pengguna Gratis')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('pro_expires_at')->where('pro_expires_at', '>', now()),
                        false: fn ($query) => $query->where(function ($q) {
                            $q->whereNull('pro_expires_at')->orWhere('pro_expires_at', '<=', now());
                        }),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
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