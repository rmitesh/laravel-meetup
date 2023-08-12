<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Manage Property';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereBelongsTo(auth()->user())
            ->latest();
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return "{$record->lead_number} - {$record->full_name}";
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['lead_number', 'full_name', 'phone_number', 'email'];
    }

    public static function getForm(): array
    {
        return [
            Forms\Components\Card::make([
                Forms\Components\TextInput::make('full_name')
                    ->placeholder('Full Name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->placeholder('Email'),

                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->placeholder('Phone Number')
                    ->required(),

                Forms\Components\Select::make('property_type')
                    ->placeholder('Property Type')
                    ->options(Lead::getPropertyType())
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->placeholder('Location')
                    ->required(),

                Forms\Components\TextInput::make('budget')
                    ->numeric()
                    ->prefix('USD')
                    ->placeholder('Budget')
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

                Forms\Components\Textarea::make('additional_requirements')
                    ->rows(2)
                    ->columnSpan('full')
                    ->placeholder('Additional requirements'),
            ])
            ->columns(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lead_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->description(fn (Model $record) => $record->email)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('property_type')
                    ->enum(Lead::getPropertyType())
                    ->description(fn (Model $record) => "$ {$record->budget}")
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('dS F, Y h:i A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('property_type')
                    ->searchable()
                    ->options(Lead::getPropertyType())
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
            RelationManagers\PropertiesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }    
}
