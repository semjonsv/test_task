<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MatchesController;

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

Route::get('/', [MainController::class, 'index']);
Route::post('/generate/division-matches/{division}', [MatchesController::class, 'generateDivisionMatches'])->name('divisionsGenerator');;
Route::post('/generate/playoff-matches', [MatchesController::class, 'generatePlayoffMatches'])->name('playoffGenerator');;
