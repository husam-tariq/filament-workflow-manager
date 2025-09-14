<?php

namespace Heloufir\FilamentWorkflowManager\Resources;

use Heloufir\FilamentWorkflowManager\Core\WorkflowHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Heloufir\FilamentWorkflowManager\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Heloufir\FilamentWorkflowManager\Resources\WorkflowResource\Relations;

class WorkflowResource extends Resource
{
    use WorkflowHelper;

    protected static ?string $model = Workflow::class;

    protected static ?string $navigationIcon = null;
    
    protected static ?string $navigationGroup = null;
    
    protected static ?int $navigationSort = null;

    public static function getNavigationIcon(): string
    {
        return config('filament-workflow-manager.navigation_icon') ?? 'heroicon-o-rectangle-stack';
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-workflow-manager.navigation_group') ?? 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-workflow-manager.navigation_sort') ?? 1;
    }

    protected static function getNavigationLabel(): string
    {
        return trans('filament-workflow-manager::filament-workflow-manager.resources.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        // NAME
                        Forms\Components\TextInput::make('name')
                            ->label(trans('filament-workflow-manager::filament-workflow-manager.resources.workflow.table.name'))
                            ->required()
                            ->maxLength(Builder::$defaultStringLength),

                        // MODEL
                        Forms\Components\Select::make('model')
                            ->label(trans('filament-workflow-manager::filament-workflow-manager.resources.workflow.table.model'))
                            ->required()
                            ->rule(fn(?Model $record) => 'unique:workflows,model,' . ($record?->id ?? 'NULL') . ',id,deleted_at,NULL')
                            ->options(self::get_workflow_models_options())
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-workflow-manager::filament-workflow-manager.resources.workflow.table.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('model')
                    ->label(trans('filament-workflow-manager::filament-workflow-manager.resources.workflow.table.model'))
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => (new $state)->workflow_model_name())
                    ->searchable(),
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
            Relations\WorkflowManager::class,
            Relations\WorkflowPermission::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \Heloufir\FilamentWorkflowManager\Resources\WorkflowResource\Pages\ListWorkflows::route('/'),
            'create' => \Heloufir\FilamentWorkflowManager\Resources\WorkflowResource\Pages\CreateWorkflow::route('/create'),
            'edit' => \Heloufir\FilamentWorkflowManager\Resources\WorkflowResource\Pages\EditWorkflow::route('/{record}/edit'),
        ];
    }
}
