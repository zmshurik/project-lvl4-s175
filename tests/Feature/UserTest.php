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

    public function testUserProfileShow()
    {
        $response = $this->get('/user/profile');
        $response->assertStatus(200);
    }
}
