<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Http\Request;

class FixturesController extends Controller
{
    public function index()
    {
        $this->generateFixtures();
        $fixtures = (new Fixture())->getFixture("all");
        return view('fixtures.index', compact('fixtures'));
    }

    public function generateFixtures()
    {
        $teams = Team::pluck('id');
        $teamsCount = $teams->count();
        $teams = $teams->toArray();
        shuffle($teams);

        // Generate matches for each week
        for ($week = 1; $week <= (($teamsCount - 1) * 2); $week++) {
            // Generate matches for each team
            for ($i = 0; $i < $teamsCount / 2; $i++) {
                $home_team = $teams[$i];
                $away_team = $teams[$teamsCount - 1 - $i];

                $fixture = new Fixture();
                $fixture->setAwayTeamId(($week <= $teamsCount - 1) ? $away_team : $home_team)
                    ->setHomeTeamId(($week <= $teamsCount - 1) ? $home_team : $away_team)
                    ->setWeekNumber($week)
                    ->setDateTime(now()->addDays($week * 7)->format('Y-m-d H:i:s'))
                    ->save();
            }

            // Rotate the teams to generate new matches for next week
            array_splice($teams, 1, 0, array_pop($teams));
        }
    }
}

