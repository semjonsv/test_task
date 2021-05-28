<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Division;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $divisions = Division::all();

        $matches = [];

        foreach ($divisions as $division) {
            foreach($division->teams as $team) {
                foreach($division->teams as $oponent) {
                    $matches[] = [
                        'matchable_id' => $team->id,
                        'division_id' => $division->id, 
                        'oponent_id' => $oponent->id,
                        'matchable_type' => 'App\Models\Team',
                        'type' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        DB::table('matches')->insert($matches);
    }
}
