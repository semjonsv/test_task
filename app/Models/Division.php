<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Division extends Model
{
    /**
     * Playoff teams amount from division
     */
    const PLAYOFF_TEAMS = 4;

    /**
     * Returns teams in specified Division
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function teams(): MorphMany
    {
        return $this->morphMany(Team::class, 'teamable');
    }

    /**
     * Returns best teams of Division
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bestTeams(): MorphMany
    {
        return $this->morphMany(Team::class, 'teamable')
            ->orderBy('score', 'desc')
            ->limit(self::PLAYOFF_TEAMS);
    }
}
