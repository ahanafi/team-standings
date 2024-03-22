<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team',
        'away_team',
        'home_score',
        'away_score',
        'the_winner'
    ];
}
