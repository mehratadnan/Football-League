<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $table = 'fixtures';

    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'week_number',
        'date_time',
        'status'
    ];


    /**
     * @return int
     */
    public function getHomeTeamId(): int
    {
        return $this->home_team_id;
    }

    /**
     * @param int $home_team_id
     * @return $this
     */
    public function setHomeTeamId(int $home_team_id): Fixture
    {
        $this->home_team_id = $home_team_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getAwayTeamId(): int
    {
        return $this->away_team_id;
    }

    /**
     * @param int $away_team_id
     * @return $this
     */
    public function setAwayTeamId(int $away_team_id): Fixture
    {
        $this->away_team_id = $away_team_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeekNumber(): int
    {
        return $this->week_number;
    }

    /**
     * @param int $week_number
     * @return $this
     */
    public function setWeekNumber(int $week_number): Fixture
    {
        $this->week_number = $week_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->date_time;
    }

    /**
     * @param string $date_time
     * @return $this
     */
    public function setDateTime(string $date_time): Fixture
    {
        $this->date_time = $date_time;
        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): Fixture
    {
        $this->status = $status;
        return $this;
    }


    /**
     * @return BelongsTo
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * @return BelongsTo
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * @return BelongsTo
     */
    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'id');
    }

    /**
     * @param $week
     * @param bool $status
     * @return mixed
     */
    public function getFixture($week, bool $status = false)
    {
        $query = self::where('status',$status);
        if($week == "all"){
            $fixture = $query->get();
        }else{
            $fixture = $query->where('week_number',$week)
                ->get();
        }
        return $fixture;

    }

    /**
     * @return mixed
     */
    public function getRemainingFixtureCount(int $team_id)
    {
        return self::where('status',false)
            ->where(function ($query) use ($team_id) {
                $query->where('home_team_id', $team_id)
                    ->orWhere('away_team_id', $team_id);
            })->count();
    }

    /**
     * @return mixed
     */
    public function getWeeksCount()
    {
        return self::max('week_number');
    }


}
