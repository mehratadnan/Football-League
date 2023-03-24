<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\FixturesController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\SimulationController;

Route::group(['prefix' => 'simulation'], function () {
    Route::get('/', [SimulationController::class, 'index'])->name('simulation.index');
    Route::get('/{week}', [SimulationController::class, 'nextWeek'])->name('simulation.nextWeek');
});

Route::group(['prefix' => 'teams'], function () {
    Route::get('/', [TeamsController::class, 'index'])->name('teams.index');
});

Route::group(['prefix' => 'reset'], function () {
    Route::get('/', [TeamsController::class, 'reset'])->name('league.reset');

});

Route::group(['prefix' => 'fixtures'], function () {
    Route::get('/', [FixturesController::class, 'index'])->name('fixtures.index');
});



