<?php

namespace Heloufir\FilamentWorkflowManager\Core;

use Heloufir\FilamentWorkflowManager\Models\Workflow;
use Heloufir\FilamentWorkflowManager\Models\WorkflowHistory;
use Heloufir\FilamentWorkflowManager\Models\WorkflowModel;
use Heloufir\FilamentWorkflowManager\Models\WorkflowModelStatus;
use Heloufir\FilamentWorkflowManager\Models\WorkflowStatus;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait InteractsWithWorkflows
{

    protected function getArrayableAppends()
    {
        $this->appends = array_unique(array_merge($this->appends, ['workflow_status_id']));

        return parent::getArrayableAppends();
    }

    public function workflow_model_name(): string
    {
        return class_basename(__CLASS__);
    }

    public function getWorkflowAttribute(): Workflow|null
    {
        return Workflow::where('model', get_class())->first();
    }

    public function getNextStatusesAttribute(): Collection
    {
        $workflow = $this->workflow;
        if ($workflow) {
            $query = WorkflowModel::query();
            $query->where('workflow_id', $workflow->id);
            $query->where('status_from_id', $this->workflow_status->status->id);
            if (config('filament-workflow-manager.permissions_enabled')) {
                $query->whereIn('status_to_id', auth()->user()->workflow_permissions->pluck('workflow_models_objects')->flatten()->pluck('status_to_id')->toArray());
            }
            return $query->get()->pluck('status_to');
        }
        return collect();
    }

    public function workflow_status(): MorphOne
    {
        return $this->morphOne(WorkflowModelStatus::class, 'modelable');
    }

    public static function getInputsPermissionsOprions()
    {
       $options=[];
       foreach (static::getInputsPermissions() as $value) {
        $options[$value]=__($value);
       }
       return $options;
    }

    public function workflow_history(): MorphMany
    {
        return $this->morphMany(WorkflowHistory::class, 'modelable');
    }


    public function status()
    {
        return $this->hasOneThrough(WorkflowStatus::class, WorkflowModelStatus::class, "modelable_id", 'id', 'id', 'workflow_status_id');
    }

    public function workflowStatus()
    {
        return $this->hasOneThrough(WorkflowStatus::class, WorkflowModelStatus::class, "modelable_id", 'id', 'id', 'workflow_status_id');
    }

    public function allFilters()
    {

        $workflow = Workflow::where('model', get_class())->first();
        if ($workflow) {
            return WorkflowModel::where('workflow_id', $workflow->id)
                ->get()
                ->pluck('status_to');
        }
        return collect();
    }

    public static function getRelationships(): array{
        return [];
    }

    public static function getInputsPermissions(): array{
        return array_merge((new (get_class()))->getFillable(),static::getRelationships());
    }

    public static function allStatus()
    {

        $workflow = Workflow::where('model', get_class())->first();
        if ($workflow) {
            return WorkflowModel::select('workflow_id','status_to_id')->where('workflow_id', $workflow->id)->with('status_to')->get()

                ->pluck('status_to');
        }
        return collect();
    }

    public function getWorkflowStatusIdAttribute()
    {
        return $this->workflow_status?->status?->id;
    }

    public static function initiate_default_status($id)
    {
        $status = Workflow::where('model', get_class())->first()->workflow_models->first();
        if ($status) {
            WorkflowModelStatus::create([
                'modelable_type' => get_class(),
                'modelable_id' => $id,
                'workflow_status_id' => $status->status_to_id
            ]);
        }
    }

    public static function defaultStatus()
    {
        return Workflow::where('model', get_class())->with('workflow_models')->first()->workflow_models->first()->status_to_id;
    }

    private function saveHistory(int|null $old_status = null): void
    {
        WorkflowHistory::create([
            'old_status_id' => $old_status,
            'new_status_id' => $this->workflow_status->workflow_status_id,
            'user_id' => auth()->user()->id,
            'modelable_type' => get_class(),
            'modelable_id' => $this->id,
            'executed_at' => now()
        ]);
    }

    public function setStatus(int $status)
    {
        $old_status = $this->workflow_status->status;
        $this->workflow_status->workflow_status_id = $status;


            if ($old_status->id != $this->workflow_status->workflow_status_id) {
                $this->saveHistory($old_status->id);
            }
              $this->workflow_status->save();
            return   $this->refresh();
    }

}
