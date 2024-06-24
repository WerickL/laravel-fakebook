<?php 
namespace Tests\Feature\Api\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    public function test_new_users_can_register_using_api(): void
    {
        Event::fake();
        $response = $this->post('/api/user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            "username" => "teste.user",
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201)->assertJson([
            'name' => 'Test User',
            'email' => 'test@example.com',
            "username" => "teste.user"
        ]);
        Event::assertDispatched(function(Registered $event){
            return $event->user->username === "teste.user";
        });
        $this->assertGuest();
    }
}