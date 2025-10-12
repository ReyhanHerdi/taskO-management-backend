<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected  $fillable = [
       'team_id',
       'user_id',
       'name_project',
       'description',
       'due',
       'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'team_id', 'id_team');
    }
    
    public function task() {
        return $this->hasMany(Task::class, 'project_id', 'id_project');
    }
}
