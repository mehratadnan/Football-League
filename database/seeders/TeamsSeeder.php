<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamsSeeder extends Seeder
{
    private $teams = [
        ['name' => 'Arsenal', 'strength' => 40],
        ['name' => 'Chelsea', 'strength' => 60],
        ['name' => 'Liverpool', 'strength' => 80],
        ['name' => 'Man United', 'strength' => 100]
    ];

    public function run()
    {
        foreach ($this->teams as $teamData) {
            $team = new Team();
            $team->setName($teamData['name'])
            ->setStrength($teamData['strength'])
            ->save();
        }
    }
}
