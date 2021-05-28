<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Match;
use App\Models\Team;
use App\Models\Division;

class GeneratePlayoffMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:playoff-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate playoff matches';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Match $matches, Team $teams): void
    {
        $matches->deleteAllPlayoffs();

        /**
         * Generate playoff matches based on divisions results
         */
        $divisions = Division::all();
        
        foreach ($divisions as $division) {
            $division_teams[] = $division->id % 2 === 0 ?
                 $division->bestTeams->sortBy('score')->values() : $division->bestTeams;
        }

        foreach ($division_teams[0] as $key => $team) {
            $winner_id = rand(0, 1) ? $team->id : $division_teams[1][$key]->id;

            $team->matches()->create([
                'oponent_id' => $division_teams[1][$key]->id,
                'type' => Match::TYPE_PLAYOFF,
                'winner_id' => $winner_id,
            ]);

            $division_teams[1][$key]->matches()->create([
                'oponent_id' => $team->id,
                'type' => Match::TYPE_PLAYOFF,
                'winner_id' => $winner_id,
            ]);
        }
        
        /**
         * Generate Semi-final matches
         */
        $playoffWinners = $teams->playoffWinners();
        
        for ($i = 0; $i < count($playoffWinners) - 1; $i+=2) {
            $team = $playoffWinners[$i];
            $oponent = $playoffWinners[$i+1];

            $winner_id = rand(0, 1) ? $team->id : $oponent->id;

            $team->matches()->create([
                'oponent_id' => $oponent->id,
                'type' => Match::TYPE_SEMI,
                'winner_id' => $winner_id,
            ]);

            $oponent->matches()->create([
                'oponent_id' => $team->id,
                'type' => Match::TYPE_SEMI,
                'winner_id' => $winner_id,
            ]);
        }

        /**
         * Upper and lower bracket finals
         */

        $brackets = [
            Match::TYPE_LOSER_FINALS => $teams->semiFinalLosers(),
            Match::TYPE_FINALS => $teams->semiFinalWinners(),
        ];

        foreach ($brackets as $type => $teams) {
            $winner_id = rand(0, 1) ? $teams[0]->id : $teams[1]->id;

            foreach ($teams as $key => $team) {
                $team->matches()->create([
                    'oponent_id' => $key % 2 ? $teams[0]->id : $teams[1]->id,
                    'type' => $type,
                    'winner_id' => $winner_id,
                ]);
            }
        }

        $this->info("Playoff matches generated!");
    }
}
