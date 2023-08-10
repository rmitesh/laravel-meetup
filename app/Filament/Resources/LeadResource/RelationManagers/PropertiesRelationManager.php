<?php

namespace App\Filament\Resources\LeadResource\RelationManagers;

use App\Filament\Resources\PropertyResource;
use App\Models\Property;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    protected static ?string $recordTitleAttribute = 'property_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PropertyResource::getFrom());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('location'),
                Tables\Columns\TextColumn::make('price')
                    ->prefix('$ '),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->successNotificationTitle('New property has been created.'),

                Tables\Actions\AttachAction::make()
                    ->label('Add New Property')
                    ->modalHeading('Add New Property')
                    ->successNotificationTitle('New property has been added.')
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        Forms\Components\Select::make('recordId')
                           ->label('Property')
                           ->searchable()
                           ->options(Property::query()->pluck('name', 'id'))
                           ->required(),
                   ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->successNotificationTitle('Property has been updated.')
                        ->label( fn ( Model $record ) =>
                            "Edit Property - {$record->name}"
                        )
                        ->modalHeading( fn ( Model $record ) =>
                            "Edit Property - {$record->name}"
                        ),

                    Tables\Actions\DetachAction::make()
                        ->successNotificationTitle('Property has been removed from this lead.'),

                    Tables\Actions\DeleteAction::make()
                        ->successNotificationTitle('Property has been deleted.'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make()
                    ->successNotificationTitle('All properties has been removed.'),

                Tables\Actions\DeleteBulkAction::make()
                    ->successNotificationTitle('All properties has been deleted.'),
            ]);
    }    
}
