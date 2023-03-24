<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    protected $table = 'teams';

    use HasFactory;

    protected $fillable = [
        'name',
        'strength',
    ];


    /**
     * @return int
     */
    public function getName(): int {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Team
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getStrength(): int {
        return $this->strength;
    }

    /**
     * @param int $strength
     * @return $this
     */
    public function setStrength(int $strength): Team
    {
        $this->strength = $strength;
        return $this;
    }

    /**
     * @return BelongsTo
     */
    public function leagueTeam(): BelongsTo
    {
        return $this->belongsTo(League::class, 'id');
    }

}
