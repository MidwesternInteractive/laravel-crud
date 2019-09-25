<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TheModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_collection_of_the_models_can_be_retreived()
    {
        $response = $this->get('/the-models');

        // Assertions
        $response->assertStatus(200);
    }
}
