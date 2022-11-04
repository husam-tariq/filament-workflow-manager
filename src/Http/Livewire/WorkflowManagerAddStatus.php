<?php

namespace Heloufir\FilamentWorkflowManager\Http\Livewire;

use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Forms\Components;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Heloufir\FilamentWorkflowManager\Models\Workflow;
use Heloufir\FilamentWorkflowManager\Models\WorkflowStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Livewire\Component;

class WorkflowManagerAddStatus extends Component implements HasForms
{
    use InteractsWithForms;

    public Workflow $workflow;

    public function mount()
    {
        $this->form->fill([
            'name' => null,
            'color' => '#f3f4f6',
            'is_end' => false,
            'disable_edit' => false,
            'with_commant' => false
        ]);
    }

    public function render()
    {
        return view('filament-workflow-manager::livewire.workflow-manager-add-status');
    }

    protected function getFormSchema(): array
    {
        return [

            Components\Grid::make(1)
             ->columns([
                'default' => 3,
                'sm' => 3,
                'md' => 3,
                'lg' => 3,
                'xl' => 3,
                '2xl' => 3,
            ])
                ->schema([
                    Components\TextInput::make('name')
                        ->label(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.form.name'))
                        ->required()->columnSpan(3)
                        ->unique(table: WorkflowStatus::class, column: 'name', ignorable: fn (?Model $record) => $record)
                        ->maxLength(Builder::$defaultStringLength),

                    Components\ColorPicker::make('color')->columnSpan(3)
                        ->label(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.form.color'))
                        ->required(),

                    Components\Checkbox::make('is_end')
                        ->label(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.form.is_end')),
                         Components\Checkbox::make('disable_edit')
                        ->label(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.form.disable_edit')),
                        Components\Checkbox::make('with_commant')
                        ->label(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.form.with_commant')),
                        Select::make('asd')->columnSpan(3)->options($this->workflow->model::getInputsPermissionsOprions())->searchable()->multiple(),

                ])
        ];
    }



    public function submit()
    {
        $data = $this->form->getState();
        $model = new WorkflowStatus();
        $model->name = $data['name'];
        $model->color = $data['color'];
        $model->is_end = $data['is_end'];
        $model->save();
        Filament::notify('success', __('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.add_status.messages.submitted'));
        $this->emit('close_add_status');
    }

    public function cancel()
    {
        $this->emit('close_add_status');
    }
}
