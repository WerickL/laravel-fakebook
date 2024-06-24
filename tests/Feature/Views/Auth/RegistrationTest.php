<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Event::fake();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            "username" => "teste.user",
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->assertAuthenticated();
        Event::assertDispatched(function(Registered $event){
            return $event->user->username === "teste.user";
        });
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_new_users_can_not_register_with_invalid_data(): void
    {
        Event::fake();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test.com', //invalid email
            "username" => "teste.user",
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        Event::assertNotDispatched(Registered::class);
        $this->assertGuest();
    }
}
