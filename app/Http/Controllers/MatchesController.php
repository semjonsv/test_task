<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class MatchesController extends Controller
{
    /**
     * Generates divisional matches
     *
     * @param Division $division
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateDivisionMatches(Division $division): RedirectResponse
    {
        Artisan::call('generate:division-matches', ['division' => $division->id]);

        return back();
    }

    /**
     * Generates playoff matches
     *
     * @return \Illuminate\Http\RedirectRespons
     */
    public function generatePlayoffMatches(): RedirectResponse
    {
        Artisan::call('generate:playoff-matches');

        return back();
    }
}
