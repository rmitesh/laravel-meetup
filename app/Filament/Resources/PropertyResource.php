<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getFrom(): array
    {
        return [
            Forms\Components\Card::make([
                Forms\Components\TextInput::make('name')
                    ->placeholder('Name')
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('USD')
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                        ->decimalSeparator('.') // Add a separator for decimal numbers.
                        ->mapToDecimalSeparator([',']) // Map additional characters to the decimal separator.
                        ->minValue(100) // Set the minimum value that the number can be.
                        ->maxValue(99999) // Set the maximum value that the number can be.
                        ->normalizeZeros() // Append or remove zeros at the end of the number.
                        ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
                        ->thousandsSeparator(','), // Add a separator for thousands.
                    )
                    ->placeholder('Price')
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->placeholder('Location')
                    ->required(),

                Forms\Components\TextInput::make('bedrooms')
                    ->numeric()
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->minValue(1) // Set the minimum value that the number can be.
                        ->maxValue(6)
                    )
                    ->placeholder('Total bedrooms')
                    ->required(),

                Forms\Components\TextInput::make('bathrooms')
                    ->numeric()
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->minValue(1) // Set the minimum value that the number can be.
                        ->maxValue(6)
                    )
                    ->placeholder('Total bathrooms')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->columnSpan('full')
                    ->placeholder('Description')
                    ->required(),
            ])
            ->columns(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFrom());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->prefix('$ ')
                    ->sortable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }    
}
