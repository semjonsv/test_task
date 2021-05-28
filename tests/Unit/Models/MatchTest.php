<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Match;

class MatchTest extends TestCase
{
    /**
     * Tests Match TYPES
     *
     * @return void
     */
    public function test_match_types()
    {
        $this->assertEquals(gettype(Match::TYPE_DIVISION), 'integer');
        
        $this->assertEquals(gettype(Match::TYPE_PLAYOFF), 'integer');

        $this->assertEquals(gettype(Match::TYPE_SEMI), 'integer');

        $this->assertEquals(gettype(Match::TYPE_LOSER_FINALS), 'integer');
        
        $this->assertEquals(gettype(Match::TYPE_FINALS), 'integer');
    }
}
