<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TodayLeadTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = "Today's Leads";

    protected function getTableQuery(): Builder
    {
        return LeadResource::getEloquentQuery()
            ->where('created_at', 'LIKE', '%'. now()->format('Y-m-d') .'%');
    }

    protected function getTableColumns(): array
    {
        return [
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
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make()
                    ->form(LeadResource::getForm())
                    ->slideOver()
                    ->successNotificationTitle('Lead has been updated.'),

                Tables\Actions\Action::make('Add Property')
                    ->icon('heroicon-o-home')
                    ->color('success')
                    ->url(fn (Model $record) => route('filament.resources.leads.edit', ['record' => $record])),
            ])
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('View All')
                ->icon('heroicon-o-external-link')
                ->iconPosition('after')
                ->url(route('filament.resources.leads.index')),

            Tables\Actions\CreateAction::make()
                ->form(LeadResource::getForm())
                ->slideOver()
                ->successNotificationTitle('Lead has been added.'),
        ];
    }
}
