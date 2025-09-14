<?php

namespace Heloufir\FilamentWorkflowManager\Resources\WorkflowResource\Relations;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Heloufir\FilamentWorkflowManager\Models\Workflow;
use Heloufir\FilamentWorkflowManager\Models\WorkflowModel;
use Illuminate\Database\Schema\Builder;
use Closure;

class WorkflowPermission extends RelationManager
{
    protected static string $view = 'filament-workflow-manager::filament.resources.workflow-resource.pages.workflow-permission';

    protected static string $relationship = 'workflow_permissions';

    protected static ?string $recordTitleAttribute = 'role';

    public static function getTitle(): string
    {
        return __('filament-workflow-manager::filament-workflow-manager.resources.permissions.title');
    }

    protected static function getModelLabel(): string
    {
        return __('filament-workflow-manager::filament-workflow-manager.resources.permissions.model');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('role')
                            ->label(__('filament-workflow-manager::filament-workflow-manager.resources.permissions.table.role'))
                            ->maxLength(Builder::$defaultStringLength)
                            ->required(),

                        Forms\Components\CheckboxList::make('workflow_models')
                            ->label(__('filament-workflow-manager::filament-workflow-manager.resources.permissions.table.models'))
                            ->options(fn($livewire) => static::workflow_models($livewire->getOwnerRecord()))
                            ->required()
                    ])
            ]);
    }

    public static function workflow_models(Workflow $workflow)
    {
        $items = WorkflowModel::where('workflow_id', $workflow->id)->whereNotNull('status_from_id')->get()->map(function (WorkflowModel $item) {
            return [
                'id' => $item->id,
                'name' => __('filament-workflow-manager::filament-workflow-manager.resources.permissions.form.transition', [
                    'status_from' => $item->status_from?->name ?? '-',
                    'status_to' => $item->status_to->name,
                ])
            ];
        })->toArray();
        $data = [];
        foreach ($items as $item) {
            $data[$item['id']] = $item['name'];
        }
        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->label(__('filament-workflow-manager::filament-workflow-manager.resources.permissions.table.role'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TagsColumn::make('workflow_models_formatted')
                    ->label(__('filament-workflow-manager::filament-workflow-manager.resources.permissions.table.models'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
