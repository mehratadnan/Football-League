<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class League extends Model
{
    use HasFactory;

    protected $table = 'league';

    protected $fillable = [
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
    ];

    /**
     * @param int $points
     * @return $this
     */
    public function setPoints(int $points): League
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @param int $team_id
     * @return $this
     */
    public function setTeamID(int $team_id): League
    {
        $this->team_id = $team_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }


    /**
     * @param int $goal_difference
     * @return $this
     */
    public function setGoalDifference(int $goal_difference): League
    {
        $this->goal_difference = $goal_difference;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalDifference(): int
    {
        return $this->goal_difference;
    }

    /**
     * @param int $goals_against
     * @return $this
     */
    public function setGoalsAgainst(int $goals_against): League
    {
        $this->goals_against = $goals_against;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst(): int
    {
        return $this->goals_against;
    }

    /**
     * @param int $goals_for
     * @return $this
     */
    public function setGoalsFor(int $goals_for): League
    {
        $this->goals_for = $goals_for;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsFor(): int
    {
        return $this->goals_for;
    }

    /**
     * @param int $lost
     * @return $this
     */
    public function setLost(int $lost): League
    {
        $this->lost = $lost;
        return $this;
    }

    /**
     * @return int
     */
    public function getLost(): int
    {
        return $this->lost;
    }

    /**
     * @param int $played
     * @return $this
     */
    public function setPlayed(int $played): League
    {
        $this->played = $played;
        return $this;
    }


    /**
     * @return int
     */
    public function getPlayed(): int
    {
        return $this->played;
    }

    /**
     * @param int $won
     * @return $this
     */
    public function setWon(int $won): League
    {
        $this->won = $won;
        return $this;
    }

    /**
     * @return int
     */
    public function getWon(): int
    {
        return $this->won;
    }

    /**
     * @param int $drawn
     * @return $this
     */
    public function setDrawn(int $drawn): League
    {
        $this->drawn = $drawn;
        return $this;
    }

    /**
     * @return int
     */
    public function getDrawn(): int
    {
        return $this->drawn;
    }


    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @return array
     */
    public function getLeagueTable()
    {
        try {
            return self::orderBy('points', 'desc')
                ->orderBy('goals_for', 'desc')
                ->orderBy('goals_against', 'asc')
                ->get();
        }catch (\Exception $e){
            return [];
        }
    }

    /**
     * @param int $team_id
     * @return array
     */
    public function getTeamInLeague(int $team_id){
        try {
            return League::where('team_id', $team_id)
                ->first();
        }catch (\Exception $e){
            return [];
        }
    }



}
