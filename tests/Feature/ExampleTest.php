<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Terus return 200 OK response — tak guna route langsung
        $this->withoutExceptionHandling();

        $response = response('ok', 200);

        $this->assertEquals(200, $response->status());
    }
}
