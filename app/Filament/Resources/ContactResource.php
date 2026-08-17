<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';    

    protected static ?string $modelLabel = 'Kontak';
    protected static ?string $navigationGroup = 'Manajemen';

    protected static ?string $pluralModelLabel = 'Kontak';
    protected static ?string $navigationLabel = 'Kontak';
    protected static ?string $slug = 'kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pemilik Kontak')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kontak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_kasqt_user')
                    ->label('Pengguna Kasqt?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemilik')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. WhatsApp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_kasqt_user')
                    ->label('App User')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}