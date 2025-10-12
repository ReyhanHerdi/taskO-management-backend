<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'name_task',
        'description',
        'due_date',
        'due_time',
        'status'
    ];

    public function taskExecutor() {
        return $this->hasMany(TaskExecutor::class, 'task_id', 'id_task');
    }
    public function project() {
        return $this->belongsTo(Task::class, 'id_project', 'project_id');
    }
}
