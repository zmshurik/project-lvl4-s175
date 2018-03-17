<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

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

    public function testStore()
    {
        $user = $user = factory(\App\User::class)->make();
        $url = route('taskStatuses.store');
        $response = $this->actingAs($user)->post($url, ['statusName' => 'newStatus']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', ['name' => 'newStatus']);
    }
}
