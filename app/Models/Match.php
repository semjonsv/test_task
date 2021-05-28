<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Match extends Model
{
    /**
     * Division match type
     */
    const TYPE_DIVISION = 0;

    /**
     * Playoff match type
     */
    const TYPE_PLAYOFF = 1;

    /**
     * Semi-final match type
     */
    const TYPE_SEMI = 2;

    /**
     * Lower bracket final type
     */
    const TYPE_LOSER_FINALS = 3;

    /**
     * Upper bracket final type
     */
    const TYPE_FINALS = 4;

    /**
     * Allow mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns matchable model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function matchable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Deletes all playoff data
     *
     * @return void
     */
    public function deleteAllPlayoffs(): void
    {
        self::where('type', '!=', self::TYPE_DIVISION)->delete();
    }

    /**
     * Matches information
     *
     * @param integer $type
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function uniqueByType(int $type): Collection
    {
        $matches = self::select(
                'matches.id as id',
                'teams.name as team_name',
                'teams.id as team_id',
                'oponents.name as oponent_name',
                'oponents.id as oponent_id',
                'divisions.name as division_name',
                'op_divisions.name as op_division_name',
                'winner_id',
            )
            ->where('type', $type)
            ->leftJoin('teams', 'teams.id', '=', 'matches.matchable_id')
            ->leftJoin('teams as oponents', 'oponents.id', '=', 'matches.oponent_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'teams.teamable_id')
            ->leftJoin('divisions as op_divisions', 'op_divisions.id', '=', 'oponents.teamable_id')
            ->get();
        
        $team_ids = [];
        foreach ($matches as $key => $match) {
            if (in_array($match->team_id, $team_ids) || in_array($match->oponent_id, $team_ids)) {
                $matches->forget($key);
            }
            
            $team_ids[] = $match->team_id;
            $team_ids[] = $match->oponent_id;
        }

        return $matches->values();
    }
}
