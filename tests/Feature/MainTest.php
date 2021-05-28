<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainTest extends TestCase
{
    /**
     * Main page availability test.
     *
     * @return void
     */
    public function test_main_screen_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
