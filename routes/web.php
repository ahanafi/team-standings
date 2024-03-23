<?php

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
});
