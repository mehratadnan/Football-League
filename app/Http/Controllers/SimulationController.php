<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\League;
use App\Models\Result;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $fixtures = (new Fixture())->getFixture(1);
        $league = (new League())->getLeagueTable();

        $data = [
            'league' => $league,
            'fixtures' => $fixtures,
            'week' => 1,
        ];

        return view('simulation.index', compact('data'));
    }

    /**
     * @param $week
     * @return Application|Factory|View
     */
    public function nextWeek($week)
    {
        $fixtures = (new Fixture())->getFixture($week);
        $this->simulate($fixtures);
        $league = (new League())->getLeagueTable();

        $totalPointsForEachTeam = (new Fixture())->getWeeksCount() * 3;

        $points = -1;
        $championship_percentage = 0;
        foreach ($league as $team) {
            if($points == -1){
                $points = $team->points;
                $team->championship_percentage = $team->points * 100 / $totalPointsForEachTeam;
                $championship_percentage += $team->championship_percentage;
                continue;
            }
            $remainingPointsForEachTeam = (new Fixture())->getRemainingFixtureCount($team->team_id) * 3;

            if(($points - $team->points) > $remainingPointsForEachTeam){
                $team->championship_percentage = 0;
            }else{
                if(empty($team->points)){
                    $team->championship_percentage = 1 * 100 / $totalPointsForEachTeam;
                }else{
                    $team->championship_percentage = $team->points * 100 / $totalPointsForEachTeam;
                }
            }
            $championship_percentage += $team->championship_percentage;
        }

        foreach ($league as $team) {
            if(!empty($team->championship_percentage)){
                $team->championship_percentage = (100 * $team->championship_percentage) / $championship_percentage;
            }
        }


        if($week == "all"){
            $data = [
                'league' => $league,
                'fixtures' => [],
                'oldFixtures' => (new Fixture())->getFixture("all" ,true),
                'week' => null,
            ];
        }else{
            $nextFixtures = (new Fixture())->getFixture($week + 1);
            $data = [
                'league' => $league,
                'fixtures' => $nextFixtures,
                'oldFixtures' => (new Fixture())->getFixture("all" ,true),
                'week' => ($nextFixtures->count() == 0) ? null : $week + 1,
            ];
        }

        return view('simulation.index', compact('data'));
    }

    /**
     * @param $fixtures
     * @return void
     */
    private function simulate($fixtures): void
    {
        if(empty($fixtures)){
            return;
        }
        foreach ($fixtures as $fixture){
            try {
                $data = $this->runMatch($fixture);
                $fixture->status = true;
                $fixture->save();

                $result = new Result();
                $result->setFixtureId($fixture->id)
                    ->setHomeTeamScore($data['homeTeamGoals'])
                    ->setAwayTeamScore($data['awayTeamGoals'])
                    ->setWinner($data['winner'])
                    ->save();


                /** @var League $homeTeam */
                $homeTeam = (new League())->getTeamInLeague($fixture->homeTeam->id);
                $homeTeam->setPlayed($homeTeam->getPlayed() +1);
                $homeTeam->setGoalsFor($homeTeam->getGoalsFor() +$data['homeTeamGoals']);
                $homeTeam->setGoalsAgainst($homeTeam->getGoalsAgainst() +$data['awayTeamGoals']);
                $homeTeam->setGoalDifference($homeTeam->getGoalDifference() +$data['homeTeamGoals'] - $data['awayTeamGoals']);
                if($data['winner'] == null){
                    $homeTeam->setDrawn($homeTeam->getDrawn() +1);
                    $homeTeam->setPoints($homeTeam->getPoints() +1);
                }elseif ($data['winner'] == $fixture->homeTeam->id){
                    $homeTeam->setWon($homeTeam->getWon() +1);
                    $homeTeam->setPoints($homeTeam->getPoints() +3);
                }else{
                    $homeTeam->setLost($homeTeam->getLost() +1);
                }
                $homeTeam->save();

                /** @var League $awayTeam */
                $awayTeam = (new League())->getTeamInLeague($fixture->awayTeam->id);
                $awayTeam->setPlayed($awayTeam->getPlayed() +1);
                $awayTeam->setGoalsFor($awayTeam->getGoalsFor() +$data['awayTeamGoals']);
                $awayTeam->setGoalsAgainst($awayTeam->getGoalsAgainst() +$data['homeTeamGoals']);
                $awayTeam->setGoalDifference($awayTeam->getGoalDifference() +$data['awayTeamGoals'] - $data['homeTeamGoals']);
                if($data['winner'] == null){
                    $awayTeam->setDrawn($awayTeam->getDrawn() +1);
                    $awayTeam->setPoints($awayTeam->getPoints() +1);
                }elseif ($data['winner'] == $fixture->awayTeam->id){
                    $awayTeam->setWon($awayTeam->getWon() +1);
                    $awayTeam->setPoints($awayTeam->getPoints() +3);
                }else{
                    $awayTeam->setLost($awayTeam->getLost() +1);
                }
                $awayTeam->save();

            }catch (Exception $e){
                return;
            }

        }

    }

    /**
     * @param Fixture $fixture
     * @return array
     */
    private function runMatch(Fixture $fixture): array
    {
        $homeTeamStrength = $fixture->homeTeam->strength;
        $homeTeamGoalsFor = $fixture->homeTeam->goals_for;
        $homeTeamGoalsAgainst = $fixture->homeTeam->goals_against;

        $awayTeamStrength = $fixture->awayTeam->strength;
        $awayTeamGoalsFor = $fixture->awayTeam->goals_for;
        $awayTeamGoalsAgainst = $fixture->awayTeam->goals_against;

        // Calculate the expected number of goals for each team based on their power percentage
        $homeExpectedGoals = $homeTeamStrength / 100 * rand(0, 3);
        $awayExpectedGoals = $awayTeamStrength / 100 * rand(0, 3);

        // Calculate the overall strength of each team based on their previous goals for and against
        if(!empty($homeTeamGoalsFor) ){
            $homeTeamPower = $homeTeamGoalsFor / ($homeTeamGoalsFor + $homeTeamGoalsAgainst);
        }else{
            $homeTeamPower = $homeTeamStrength / 100;
        }

        if(!empty($awayTeamGoalsFor) ){
            $awayTeamPower = $awayTeamGoalsFor / ($awayTeamGoalsFor + $awayTeamGoalsAgainst);
        }else{
            $awayTeamPower = $awayTeamStrength / 100;
        }

        // Calculate the expected number of goals for each team based on their overall strength
        $homeTeamGoals = intval(round($homeExpectedGoals * $homeTeamPower));
        $awayTeamGoals = intval(round($awayExpectedGoals * $awayTeamPower));

        if($homeTeamGoals > $awayTeamGoals){
            $winner = $fixture->homeTeam->id;
        }else if($homeTeamGoals < $awayTeamGoals){
            $winner = $fixture->awayTeam->id;
        }else{
            $winner = null;
        }

        return [
            'winner' => $winner,
            'homeTeamGoals' => $homeTeamGoals,
            'awayTeamGoals' => $awayTeamGoals,
        ];
    }

}
