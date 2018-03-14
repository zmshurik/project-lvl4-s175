<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    public function testUserIndex()
    {
        $user = factory(\App\User::class)->make();
        $url = route('users.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }

    public function testUserProfile()
    {
        $user = factory(\App\User::class)->create();
        $url1 = route('users.edit', ['id' => $user->id]);
        $getResponse = $this->actingAs($user)->get($url1);
        $getResponse->assertStatus(200);
        $url2 = route('users.update', ['id' => $user->id]);
        $saveResponse = $this->actingAs($user)->patch($url2, ['name' => 'newName', 'email' => $user->email]);
        $this->assertDatabaseHas('users', [
            'name' => 'newName'
        ]);
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class)->create();
        $url = route('users.destroy', ['id' => $user->id]);
        $saveResponse = $this->actingAs($user)->delete($url);
        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
