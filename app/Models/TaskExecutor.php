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
        return $this->hasMany(User::class, 'id_user', 'user_id');
    }

    public function task() {
        return $this->hasMany(task::class, 'id_task', 'task_id');
    }
}
