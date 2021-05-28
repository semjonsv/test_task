<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'A', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'B', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'C', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'D', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'E', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'F', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'G', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'H', 'teamable_id' => 1, 'score' => 0],
            ['name' => 'I', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'J', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'K', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'L', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'M', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'N', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'O', 'teamable_id' => 2, 'score' => 0],
            ['name' => 'P', 'teamable_id' => 2, 'score' => 0],
        ];

        foreach ($teams as &$team) {
            $team['teamable_type'] = 'App\Models\Division';
            $team['created_at'] = Carbon::now();
            $team['updated_at'] = Carbon::now();
        }

        DB::table('teams')->insert($teams);
    }
}
