<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Division;

class DivisionTest extends TestCase
{
    /**
     * Tests Division PLAYOFF_TEAMS
     *
     * @return void
     */
    public function test_division_playoff_teams()
    {
        $this->assertEquals(gettype(Division::PLAYOFF_TEAMS), 'integer');
    }
}
