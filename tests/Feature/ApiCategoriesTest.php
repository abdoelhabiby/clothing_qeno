<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiCategoriesTest extends TestCase
{


    public function testExampleResponseJsone()
    {
        $response = $this->get('/api/categories');

        dd($response);

        $response->assertStatus(422);
    }
}
