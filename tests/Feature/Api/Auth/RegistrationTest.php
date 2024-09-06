<?php 
namespace Tests\Feature\Api\Auth;

use Api\User\Model\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;
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

    public function test_new_users_can_not_register_with_invalid_data_using_api(): void
    {
        Event::fake();
        $response = $this->post('/api/user', [
            'name' => 'Test User',
            'email' => 'test.com', //invalid email
            "username" => "teste.user",
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(422);
        Event::assertNotDispatched(Registered::class);
        $this->assertGuest();
    }
    public function test_users_can_not_change_another_user_using_api(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->post('/api/user', [
            'name' => $user->name,
            'email' => $user->email,
            "username" =>$user->username,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201)->assertJson([
            'name' => 'Test User',
            'email' => 'test@example.com',
            "username" => "teste.user"
        ]);
        dd($response);
        Passport::actingAs($user);
        $response = $this->patch('/api/user/'. $user->id, [
            "username" => "teste.user",
        ]);
        $response->assertStatus(403);
    }
}