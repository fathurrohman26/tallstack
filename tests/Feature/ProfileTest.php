<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_profile_page_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertOk();
    }

    /** @test */
    public function test_profile_page_can_not_be_displayed_if_email_is_unverified()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->assertNull($user->email_verified_at);

        $response = $this
            ->actingAs($user)
            ->get(route('profile'));

        $response->assertRedirect(route('verification.notice'));
    }

    /** @test */
    public function test_profile_information_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.update'), [
                'email' => 'test@example.mail',
                'name'  => 'Test User'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home'));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.mail', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function test_user_password_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.update'), [
                'email' => 'test@example.mail',
                'name'  => 'Test User'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home'));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.mail', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile'));

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    /** @test */
    public function test_user_can_delete_their_account()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('profile.delete'), [
                'delete_password' => 'password'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home', ['reason' => 'bye']));

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    /** @test */
    public function test_correct_password_must_be_provided_to_delete_account()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('profile'))
            ->delete(route('profile.delete'), [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHas('deleting_account', true)
            ->assertSessionHas('delete_password', 'The password is incorrect.')
            ->assertRedirect(route('profile'));

        $this->assertNotNull($user->fresh());
    }
}
