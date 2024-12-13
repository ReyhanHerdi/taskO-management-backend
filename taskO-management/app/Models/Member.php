<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'team_id',
        'role'
    ];

    public function team() {
        return $this->hasMany(Team::class, 'id_team', 'team_id');
    }

    public function user() {
        return $this->hasMany(User::class, 'id_user', 'user_id');
    }
}
