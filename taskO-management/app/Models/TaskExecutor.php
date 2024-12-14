<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskExecutor extends Model
{
    protected $fillable = [
        'task_id',
        'user_id'
    ];

    public function user() {
        return $this->hasMany(User::class, 'user_id', 'id_user');
    }

    public function task() {
        return $this->hasMany(task::class, 'task_id', 'id_task');
    }
}
