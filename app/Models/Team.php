<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'city', 'slug',
        'played', 'won', 'drawn', 'lost', 'goal_for', 'goal_against', 'points'
    ];
}
