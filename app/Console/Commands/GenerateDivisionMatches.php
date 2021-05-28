<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Console\Command;

class GenerateDivisionMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:division-matches {division}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate division matches';

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
    public function handle(): void
    {
        $division = Division::findOrFail($this->argument('division'));

        $division->teams()->update([
            'score' => 0,
        ]);
        
        /**
         * Might refactor this to use division->matches()
         */
        Match::where('division_id', $division->id)->update([
            'winner_id' => null,
        ]);

        foreach($division->teams as $team) {
            foreach ($team->divisionMatches as $match) {
                if ($match->oponent_id === $match->matchable_id) {
                    continue;
                }

                $oponent_perspective = $match->where('matchable_id', $match->oponent_id)
                    ->where('oponent_id', $match->matchable_id)->first();

                if ($oponent_perspective->winner_id) {
                    $match->winner_id = $oponent_perspective->winner_id;
                } else {
                    $match->winner_id = rand(0, 1) ? $match->matchable_id : $match->oponent_id;
                }

                $match->save();
            }

            $team->score = $team->countScore();
            $team->save();
        }

        $this->info("'{$division->name}' matches generated!");
    }
}
