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
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200);
    }

    public function testUserProfile()
    {
        $user = factory(\App\User::class)->make();
        $getResponse = $this->actingAs($user)->get('/user/profile/edit');
        $getResponse->assertStatus(200);
        $saveResponse = $this->actingAs($user)->patch('/user/profile', ['name' => 'newName', 'email' => $user->email]);
        $this->assertDatabaseHas('users', [
            'name' => 'newName'
        ]);
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class)->make();
        $saveResponse = $this->actingAs($user)->delete('/user/profile');
        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
