<?php

namespace Heloufir\FilamentWorkflowManager\Http\Livewire;

use Filament\Notifications\Notification;
use Heloufir\FilamentWorkflowManager\Models\WorkflowModel;
use Livewire\Component;

class WorkflowManagerDelete extends Component
{

    public WorkflowModel $record;

    public function render()
    {
        return view('filament-workflow-manager::livewire.workflow-manager-delete');
    }

    public function submit()
    {
        $this->record->delete();
        Notification::make()
            ->success()
            ->title(__('filament-workflow-manager::filament-workflow-manager.resources.workflow.page.workflow.modal.delete.messages.deleted'))
            ->send();
        $this->dispatch('close_workflow_manager_delete_dialog');
    }

    public function cancel()
    {
        $this->dispatch('close_workflow_manager_delete_dialog');
    }
}
