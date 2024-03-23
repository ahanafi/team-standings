<?php

use App\Http\Controllers\MatchResultController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');


// Ajax routes
Route::group([
    'prefix' => 'ajax',
    'as' => 'ajax.'
], function () {

    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('teams', [TeamController::class, 'ajaxGetAllTeams'])->name('teams.get-all-teams');

    Route::group([
        'prefix' => 'match-result',
        'as' => 'match-result.'
    ], function () {
        Route::post('save-result', [MatchResultController::class, 'store'])->name('save-result');
    });
});
