<?php

namespace Heloufir\FilamentWorkflowManager\Resources\ModelResource;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class WorkflowHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'workflow_history';

    public static function getTitle(): string
    {
        return trans('filament-workflow-manager::filament-workflow-manager.page.history.title');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('old_status.name')
                        ->label(trans('filament-workflow-manager::filament-workflow-manager.page.history.table.old_status'))
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('new_status.name')
                        ->label(trans('filament-workflow-manager::filament-workflow-manager.page.history.table.new_status'))
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('user.' . config('filament-workflow-manager.user_name'))
                        ->label(trans('filament-workflow-manager::filament-workflow-manager.page.history.table.changed_by'))
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('executed_at')
                        ->label(trans('filament-workflow-manager::filament-workflow-manager.page.history.table.changed_at'))
                        ->searchable()
                        ->sortable()
                        ->dateTime(trans('filament-workflow-manager::filament-workflow-manager.page.history.data.date_format'))->since(),

            ]);
    }

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }

    protected function canDelete(Model $record): bool
    {
        return false;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }
}
