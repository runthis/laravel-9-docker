<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class Auth extends TestCase
{
    /**
     * Migrate the database.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    /**
     * Test if they can reach the login route.
     */
    public function testCanReachLoginPage(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    /**
     * Test if they can see the text "Sign in" on the login page.
     */
    public function testCanSeeSignInText(): void
    {
        $response = $this->get(route('login'));

        $response->assertSee('Sign in');
    }

    /**
     * Test if the auth.google route redirects somewhere.
     */
    public function testCanRedirectToAuthProviderGoogle(): void
    {
        $response = $this->get(route('auth.google'));

        $response->assertStatus(302);
    }

    /**
     * Test if the home page can not be seen without logging in first.
     */
    public function testCanNotReachHomePageWhileNotLoggedIn(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    /**
     * Test if the home page can be seen after logging in.
     */
    public function testCanReachHomePageWhileLoggedIn(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'google_id' => 'abc123',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
    }
}
