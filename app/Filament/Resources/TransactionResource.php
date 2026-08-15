<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    

    // Tambahkan 4 baris ini untuk mengubah nama dan URL ke Bahasa Indonesia
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $slug = 'transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('creator_id')
                    ->label('Dibuat Oleh')
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('contact_id')
                    ->label('Kontak Manual (Jika pihak ke-2 tidak punya App)')
                    ->relationship('contact', 'name')
                    ->searchable(),
                Forms\Components\Select::make('counterparty_id')
                    ->label('Pihak Ke-2 (Jika punya App)')
                    ->relationship('counterparty', 'name')
                    ->searchable(),
                
                Forms\Components\Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'hutang' => 'Hutang',
                        'piutang' => 'Piutang',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'PENDING_APPROVAL' => 'Menunggu Persetujuan',
                        'ACTIVE' => 'Aktif / Berjalan',
                        'DISPUTED' => 'Disanggah',
                        'PAID' => 'Lunas',
                    ])
                    ->required()
                    ->default('ACTIVE'),

                Forms\Components\TextInput::make('amount')
                    ->label('Nominal Transaksi')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('remaining_amount')
                    ->label('Sisa Tagihan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                
                Forms\Components\DatePicker::make('due_date')
                    ->label('Jatuh Tempo'),
                
                Forms\Components\Textarea::make('description')
                    ->label('Catatan / Deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Pembuat')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Jenis')
                    ->colors([
                        'danger' => 'hutang',
                        'success' => 'piutang',
                    ]),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remaining_amount')
                    ->label('Sisa Tagihan')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'PENDING_APPROVAL',
                        'success' => 'ACTIVE',
                        'danger' => 'DISPUTED',
                        'secondary' => 'PAID',
                    ]),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}