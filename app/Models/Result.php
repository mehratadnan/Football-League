<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'home_team_score',
        'away_team_score',
        'winner'
    ];

    /**
     * @return int
     */
    public function getFixtureId(): int {
        return $this->fixture_id;
    }

    /**
     * @param int $fixture_id
     * @return $this
     */
    public function setFixtureId(int $fixture_id): Result
    {
        $this->fixture_id = $fixture_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHomeTeamScore(): int {
        return $this->home_team_score;
    }

    /**
     * @param int $score
     * @return $this
     */
    public function setHomeTeamScore(int $score): Result
    {
        $this->home_team_score = $score;
        return $this;
    }

    /**
     * @return int
     */
    public function getAwayTeamScore(): int {
        return $this->away_team_score;
    }

    /**
     * @param int $score
     * @return $this
     */
    public function setAwayTeamScore(int $score): Result
    {
        $this->away_team_score = $score;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getWinner(): ?int {
        return $this->winner;
    }

    /**
     * @param int|null $winner
     * @return $this
     */
    public function setWinner(?int $winner) {
        $this->winner = $winner;
        return $this;
    }


}
