<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStatus()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeText('Stock');
    }
}
