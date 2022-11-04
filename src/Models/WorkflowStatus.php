<?php

namespace Heloufir\FilamentWorkflowManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'workflow_id',
        'name',
        'color',
        'with_commant',
        'disable_edit',
        'disable_options',
      //  'is_done',
        'is_end'
    ];
}
