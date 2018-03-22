<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFilter()
    {
        $user = factory(\App\User::class)->make();
        $tasks = factory(\App\Task::class, 10)->create();
        $url = route('filter.store');
        $response = $this->actingAs($user)->post($url, [
            'statusId' => 1,
            'my' => 1,
            'assignedToId' => $user->id
        ]);
        $response->assertStatus(200);
    }
}
