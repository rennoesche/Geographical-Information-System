<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KabupatenKotaResource\Pages;
use App\Filament\Resources\KabupatenKotaResource\RelationManagers;
use App\Models\KabupatenKota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KabupatenKotaResource extends Resource
{
    protected static ?string $model = KabupatenKota::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provinsi_id')
                    ->label('Provinsi')
                    ->options(
                        \App\Models\Provinsi::all()->pluck('nama', 'id')->toArray()
                    )
                    ->required(),
                Forms\Components\TextInput::make('nama')->label('Nama Kab./kota')->required()->maxLength(255),
                Forms\Components\TextInput::make('alt_name')->label('Nama Alternatif'),
                Forms\Components\TextInput::make('latitude')->label('Latitude')->required()->numeric(),
                Forms\Components\TextInput::make('longitude')->label('Longitude')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provinsi.nama')
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alt_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
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
            'index' => Pages\ListKabupatenKotas::route('/'),
            'create' => Pages\CreateKabupatenKota::route('/create'),
            'edit' => Pages\EditKabupatenKota::route('/{record}/edit'),
        ];
    }
}
