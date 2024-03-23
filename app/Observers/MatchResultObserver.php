<?php

namespace App\Observers;

use App\Models\MatchResult;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class MatchResultObserver
{
    /**
     * Handle the MatchResult "created" event.
     */
    public function created(MatchResult $matchResult): void
    {
        $homeTeam = Team::where('id', $matchResult->home_team)->first();
        $awayTeam = Team::where('id', $matchResult->away_team)->first();

        Log::debug("MatchResult", $matchResult->toArray());
        Log::debug("home_team: ", $homeTeam->toArray());
        Log::debug("away_team: ", $awayTeam->toArray());

        $homeTeamPoint = 0;
        $awayTeamPoint = 0;

        $homeTeamDrawn = 0;
        $awayTeamDrawn = 0;

        $homeTeamWin = 0;
        $awayTeamWin = 0;

        $homeTeamLost = 0;
        $awayTeamLost = 0;

        // drawn
        if ($matchResult->the_winner === null) {
            $homeTeamPoint = 1;
            $awayTeamPoint = 1;

            $homeTeamDrawn = 1;
            $awayTeamDrawn = 1;
        } else if ($matchResult->the_winner === 'HOME') {
            $homeTeamPoint = 3;
            $awayTeamPoint = 0;

            $homeTeamWin = 1;
            $awayTeamLost = 1;
        } else if ($matchResult->the_winner === 'AWAY') {
            $homeTeamPoint = 0;
            $awayTeamPoint = 3;

            $homeTeamLost = 1;
            $awayTeamWin = 1;
        }

        $homeTeam->update([
            'played' => $homeTeam->played + 1,
            'won' => $homeTeam->won + $homeTeamWin,
            'drawn' => $homeTeam->drawn + $homeTeamDrawn,
            'lost' => $homeTeam->lost + $homeTeamLost,
            'goal_for' => $homeTeam->goal_for + $matchResult->home_score,
            'goal_against' => $homeTeam->played + $matchResult->away_score,
            'points' => $homeTeam->points + $homeTeamPoint
        ]);


        $awayTeam->update([
            'played' => $awayTeam->played + 1,
            'won' => $awayTeam->won + $awayTeamWin,
            'drawn' => $awayTeam->drawn + $awayTeamDrawn,
            'lost' => $awayTeam->lost + $awayTeamLost,
            'goal_for' => $awayTeam->goal_for + $matchResult->away_score,
            'goal_against' => $awayTeam->played + $matchResult->home_score,
            'points' => $awayTeam->points + $awayTeamPoint
        ]);
    }

    /**
     * Handle the MatchResult "updated" event.
     */
    public function updated(MatchResult $matchResult): void
    {
        //
    }

    /**
     * Handle the MatchResult "deleted" event.
     */
    public function deleted(MatchResult $matchResult): void
    {
        //
    }

    /**
     * Handle the MatchResult "restored" event.
     */
    public function restored(MatchResult $matchResult): void
    {
        //
    }

    /**
     * Handle the MatchResult "force deleted" event.
     */
    public function forceDeleted(MatchResult $matchResult): void
    {
        //
    }
}
