<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorTest extends TestCase
{
    /**
     * Division matches generators test.
     *
     * @return void
     */
    public function test_division_matches_can_be_generated()
    {
        $response = $this->post('/generate/division-matches/1');

        $response->assertRedirect('/');
    }

    /**
     * Playoff matches generators test.
     *
     * @return void
     */
    public function test_playoff_matches_can_be_generated()
    {        
        $response = $this->post('/generate/playoff-matches');

        $response->assertRedirect('/');
    }
}
