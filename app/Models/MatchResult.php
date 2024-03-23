<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team')
            ->select('id', 'name', 'city', 'slug');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team')
            ->select('id', 'name', 'city', 'slug');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($date) => Carbon::parse($date)->diffForHumans()
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($date) => Carbon::parse($date)->diffForHumans()
        );
    }
}
