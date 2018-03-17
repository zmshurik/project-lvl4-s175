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

    public function testEdit()
    {
        $user = factory(\App\User::class)->make();
        $status = factory(\App\TaskStatus::class)->create();
        $url = route('taskStatuses.edit', ['id' => $status->id]);
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = factory(\App\User::class)->make();
        $status = factory(\App\TaskStatus::class)->create(['name' => 'notEditedStatus']);
        $url = route('taskStatuses.update', ['id' => $status->id]);
        $response = $this->actingAs($user)->patch($url, ['statusName' => 'editedStatus']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', ['name' => 'editedStatus']);
    }

    public function testDestroy()
    {
        $user = factory(\App\User::class)->make();
        $status = factory(\App\TaskStatus::class)->create(['name' => 'for deletion']);
        $url = route('taskStatuses.destroy', ['id' => $status->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('task_statuses', ['name' => 'for deletion']);
    }
}
