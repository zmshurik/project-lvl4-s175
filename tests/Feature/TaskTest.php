<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
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
        factory(\App\Task::class, 3)->make();
        $url = route('tasks.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }
    public function testCreate()
    {
        $user = factory(\App\User::class)->make();
        $url = route('tasks.create');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }
}
