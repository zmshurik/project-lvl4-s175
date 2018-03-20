<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTags()
    {
        $user = factory(\App\User::class)->create();
        $url = route('tasks.store');
        $response = $this->actingAs($user)->post($url, [
            'name' => 'newTask',
            'assignedToId' => $user->id,
            'tagsStr' => 'new, main, important'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tags', ['name' => 'new']);
        $this->assertDatabaseHas('tags', ['name' => 'main']);
        $this->assertDatabaseHas('tags', ['name' => 'important']);
        $this->assertCount(3, Task::first()->tags);
    }

    public function testUpdateTags()
    {
        $user = factory(\App\User::class)->create();
        $task = factory(\App\Task::class)->create();
        $tags = factory(\App\Tag::class, 5)->create();
        $tagsIds = $tags->pluck('id')->all();
        $task->tags()->attach($tagsIds);
        $url = route('tasks.update', ['id'=>$task->id]);
        $response = $this->actingAs($user)->patch($url, [
            'name' => 'newTaskName',
            'description' => 'i updated',
            'assignedToId' => $task->assignedTo->id,
            'statusId' => $task->status->id,
            'tagsStr' => 'tag1, tag2'
        ]);
        $response->assertStatus(302);
        $this->assertCount(2, Task::first()->tags);
    }

    public function testShouldNotCreateEmptyTag()
    {
        $user = factory(\App\User::class)->create();
        $url = route('tasks.store');
        $response = $this->actingAs($user)->post($url, [
            'name' => 'newTask',
            'assignedToId' => $user->id,
            'tagsStr' => 'new, main, ,'
        ]);
        $response = $this->actingAs($user)->post($url, [
            'name' => 'oneMoreTask',
            'assignedToId' => $user->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tags', ['name' => '']);
    }
}
