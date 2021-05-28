<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;

class Team extends Model
{
    /**
     * Returns teamable model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function teamable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Returns division matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function divisionMatches(): MorphMany
    {
        return $this->morphMany(Match::class, 'matchable')
            ->where('type', Match::TYPE_DIVISION);
    }

    /**
     * Returns all team matches
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function matches(): MorphMany
    {
        return $this->morphMany(Match::class, 'matchable');
    }

    /**
     * Returns team divisional score
     *
     * @return int
     */
    public function countScore(): int
    {
        return $this->morphMany(Match::class, 'matchable')
            ->where('type', Match::TYPE_DIVISION)
            ->where('winner_id', $this->id)
            ->count();
    }

    /**
     * Returns playoff winners
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function playoffWinners(): Collection
    {
        return self::select('teams.*')
            ->where('matches.type', Match::TYPE_PLAYOFF)
            ->join('matches', 'matches.winner_id', '=', 'teams.id')
            ->distinct()->get();
    }

    /**
     * Returns semi-final winners
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function semiFinalWinners(): Collection
    {
        return self::select('teams.*')
            ->where('matches.type', Match::TYPE_SEMI)
            ->join('matches', 'matches.winner_id', '=', 'teams.id')
            ->distinct()->get();
    }

    /**
     * Returns semi-final losers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function semiFinalLosers(): Collection
    {
        return self::select('teams.*')
            ->where('matches.type', Match::TYPE_SEMI)
            ->join("matches", function ($join) {
                $join->on('matches.matchable_id', '=', 'teams.id')
                    ->on('matches.winner_id', '!=', 'teams.id');
            })
            ->distinct()->get();
    }
}
