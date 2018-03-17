<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

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
        $patchUrl = route('users.update', ['id' => $user->id]);
        $patchResponse = $this->actingAs($user)->patch($patchUrl, ['name' => 'newName', 'email' => $user->email]);
        $patchResponse->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'newName'
        ]);
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class)->create();
        $url = route('users.destroy', ['id' => $user->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', $user->toArray());
    }

    public function testPassword()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt('myOldPwd')
        ]);
        $url = route('password.index');
        $getResponse = $this->actingAs($user)->get($url);
        $getResponse->assertStatus(200);
        $newPwd = 'myNewPwd';
        $postUrl = route('password.store');
        $postResponse = $this->actingAs($user)->post($postUrl, [
            'current-password' => 'myOldPwd',
            'new-password' => $newPwd,
            'new-password_confirmation' => $newPwd
        ]);
        $postResponse->assertStatus(302);
        $this->assertTrue(Hash::check($newPwd, $user->password));
    }
}
