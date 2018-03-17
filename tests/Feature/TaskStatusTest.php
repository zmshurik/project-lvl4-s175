<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(\App\User::class)->make();
        $url = route('taskStatuses.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }
}
