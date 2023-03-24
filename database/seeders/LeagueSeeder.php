<?php

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    private $teams = [
        ['team_id' => 1],
        ['team_id' => 2],
        ['team_id' => 3],
        ['team_id' => 4]
    ];

    public function run()
    {
        foreach ($this->teams as $teamData) {
            (new League)->setTeamId($teamData['team_id'])
                ->save();
        }
    }
}
