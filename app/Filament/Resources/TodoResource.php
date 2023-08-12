<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TodoResource\Actions;
use App\Filament\Resources\TodoResource\Pages;
use App\Filament\Resources\TodoResource\RelationManagers;
use App\Models\Todo;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;

    protected static ?string $navigationGroup = 'Manage Todos';

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereBelongsTo(auth()->user())
            ->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->placeholder('Title')
                            ->afterStateUpdated(function (\Closure $set, ?string $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->reactive()
                            ->required(),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->placeholder('Slug')
                            ->required(),

                        Forms\Components\MarkdownEditor::make('description')
                            ->placeholder('Add task description...')
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\Select::make('priority')
                            ->placeholder('Select priority')
                            ->options(Todo::getPriority())
                            ->searchable()
                            ->required(),

                        Forms\Components\DateTimePicker::make('due_at')
                            ->placeholder('Due Date'),

                        Forms\Components\Checkbox::make('status'),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('priority')
                    ->sortable()
                    ->enum(Todo::getPriority())
                    ->colors([
                        'danger',
                        'primary' => 2,
                        'info' => 3,
                        'secondary' => 4,
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->sortable()
                    ->enum([
                        0 => 'Pending',
                        1 => 'Completed',
                    ])
                    ->colors([
                        'primary',
                        'success' => true,
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('dS F, Y h:i A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority')
                    ->options(Todo::getPriority())
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Actions\CommentAction::make()
                        ->successNotificationTitle('Comment has been added.'),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTodos::route('/'),
            'create' => Pages\CreateTodo::route('/create'),
            'edit' => Pages\EditTodo::route('/{record}/edit'),
        ];
    }    
}
