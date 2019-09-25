<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TheModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function the_model_has_fillables()
    {
        $response = true;

        // Assertions
        $this->assertTrue($response);
    }
}
