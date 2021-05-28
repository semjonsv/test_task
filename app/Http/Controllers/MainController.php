<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Match;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    /**
     * Main application page
     *
     * @param Match $matches
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Match $matches): View
    {
        $divisions = Division::all();

        foreach ($divisions as $division) {
            foreach($division->teams as $team) {
                $team->matches = $team->divisionMatches;
            }
        }
        
        return view('main', [
            'playoffs' => $matches->uniqueByType(Match::TYPE_PLAYOFF),
            'semis' => $matches->uniqueByType(Match::TYPE_SEMI),
            'loser_finals' => $matches->uniqueByType(Match::TYPE_LOSER_FINALS)->first(),
            'finals' => $matches->uniqueByType(Match::TYPE_FINALS)->first(),
            'divisions' => $divisions,
        ]);
    }
}
