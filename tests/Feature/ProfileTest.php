<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('profile'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name'
        ]);
    }
}
