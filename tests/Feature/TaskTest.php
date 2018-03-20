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

    public function testEdit()
    {
        $user = factory(\App\User::class)->make();
        $tasks = factory(\App\Task::class, 3)->create();
        $url = route('tasks.edit', ['id' => $tasks->first()]);
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = factory(\App\User::class)->create();
        $url = route('tasks.store');
        $response = $this->actingAs($user)->post($url, [
            'name' => 'newTask',
            'assignedToId' => $user->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['name' => 'newTask']);
    }

    public function testUpdate()
    {
        $user = factory(\App\User::class)->create();
        $tasks = factory(\App\Task::class, 3)->create();
        $task = $tasks->first();
        $url = route('tasks.update', ['id'=>$task->id]);
        $response = $this->actingAs($user)->patch($url, [
            'name' => 'newTaskName',
            'description' => 'i updated',
            'assignedToId' => $task->assignedTo->id,
            'statusId' => $task->status->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'name' => 'newTaskName',
            'description' => 'i updated'
        ]);
    }

    public function testDestroy()
    {
        $user = factory(\App\User::class)->make();
        $tasks = factory(\App\Task::class, 3)->create();
        $task = \App\Task::first();
        $url = route('tasks.destroy', ['id' => $task->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertCount(2, \App\Task::all());
    }

    public function testShouldNotUpdateWithTrashedAssignedUser()
    {
        $user = factory(\App\User::class)->create();
        $task = factory(\App\Task::class)->create();
        $deletedUser = $task->assignedTo;
        $deletedUser->delete();
        $url = route('tasks.update', ['id'=>$task->id]);
        $response = $this->actingAs($user)->patch($url, [
            'name' => 'newTaskName',
            'description' => 'i updated',
            'assignedToId' => $task->assignedTo->id,
            'statusId' => $task->status->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks', [
            'name' => 'newTaskName',
            'description' => 'i updated'
        ]);
    }
}
