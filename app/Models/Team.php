<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_team',
        'description'
    ];

    public function member() {
        return $this->hasMany(Member::class, 'team_id', 'id_team');
    }

    public function project() {
        return $this->hasMany(Project::class, 'team_id', 'id_team');
    }
}
