<?php

namespace Heloufir\FilamentWorkflowManager\Tables\Columns;

use App\Models\User;
use Closure;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Heloufir\FilamentWorkflowManager\Forms\Components\WorkflowStatusInput;
use Heloufir\FilamentWorkflowManager\Models\WorkflowHistory;
use Illuminate\Database\Eloquent\Model;

class WorkflowStatusColumn extends Column
{
    protected string $view = 'filament-workflow-manager::tables.columns.workflow-status-column';

    public static function make(string $name = null): static
    {
        return parent::make('status')->action(Action::make('updateAuthor')
        ->successNotificationTitle('User updated')
        ->mountUsing(fn (ComponentContainer $form, Model $record) => $form->fill([
            'workflow_status_id' => $record->workflow_status_id,
        ]))->visible(fn(Model $record)=>  !$record->status->is_end  )
        ->action(function (Model $record, array $data): void {
            $old_status = $record->workflow_status->status;
            $record->workflow_status->workflow_status_id = $data['workflow_status_id'];
            $record->workflow_status->save();
            $record->refresh();
            if ($old_status->id != $record->workflow_status->workflow_status_id) {
                $this->saveHistory($old_status->id,$record);
                $this->action->sendSuccessNotification();
                $this->render();
            }
        })
        ->form([
            WorkflowStatusInput::make(),
        ]));
    }


    private function saveHistory(int|null $old_status = null,Model $record): void
    {
        WorkflowHistory::create([
            'old_status_id' => $old_status,
            'new_status_id' => $record->workflow_status->workflow_status_id,
            'user_id' => auth()->user()->id,
            'modelable_type' => get_class($record),
            'modelable_id' => $record->id,
            'executed_at' => now()
        ]);
    }
}
