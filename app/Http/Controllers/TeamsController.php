<?php
namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;

class TeamsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $teams = Team::all(['name']);
        return view('teams.index', compact('teams'));
    }

    public function reset()
    {
        Artisan::call('migrate:fresh --seed');
        return $this->index();
    }


}
