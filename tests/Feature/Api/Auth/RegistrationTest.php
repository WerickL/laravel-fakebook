<?php 
namespace Tests\Feature\Api\Auth;

use Api\User\Model\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $user2 = User::factory()->create();
        $response = $this->postJson('/api/user', [
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
        $responseData = $response->json();
        $userId = $responseData['id'];
        Passport::actingAs($user2);
        $response = $this->patchJson("/api/user/$userId", [
            "username" => "teste.user",
        ]);
        $response->assertStatus(403);
    }
    public function test_users_can_change_your_own_user_using_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->patchJson("/api/user/$user->id", [
            "username" => "teste.user",
        ]);
        $response->assertStatus(200);
    }
    public function test_following_relationship_is_created()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->following()->attach($user2->id);

        $this->assertDatabaseHas('follows', [
            'follower_user_id' => $user1->id,
            'followed_user_id' => $user2->id
        ]);
    }
    public function test_user_can_retrieve_followers()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->following()->attach($user2->id);

        $this->assertTrue($user2->followers->contains($user1));
    }
    public function test_user_can_retrieve_following()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
    
        $user1->following()->attach($user2->id);
    
        $this->assertTrue($user1->following->contains($user2));
    }
    // public function test_user_cannot_follow_same_user_twice()
    // {
    //     $user1 = User::factory()->create();
    //     $user2 = User::factory()->create();

    //     $user1->following()->attach($user2->id);
    //     $user1->following()->attach($user2->id); // Deve ser ignorado pelo banco (se a tabela pivot for única)

    //     $this->assertEquals(1, DB::table('follows')
    //         ->where('follower_user_id', $user1->id)
    //         ->where('followed_user_id', $user2->id)
    //         ->count()
    //     );
    // }
    public function test_user_can_follow_another_user_via_api()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Passport::actingAs($user1);
        $response = $this->getJson("/api/user/follow/$user2->id");
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User followed successfully'
            ]);

        $this->assertDatabaseHas('follows', [
            'follower_user_id' => $user1->id,
            'followed_user_id' => $user2->id
        ]);
    }
    public function test_user_cannot_follow_same_user_twice_via_api()
{
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Seguir o usuário 2 duas vezes
     Passport::actingAs($user1);
     $response =$this->getJson("/api/user/follow/$user2->id");
     $response =$this->getJson("/api/user/follow/$user2->id");
    // Verifica se a resposta indica que já segue o usuário
    $response->assertStatus(400);
    

    // Verifica se só há um registro no banco
    $this->assertEquals(1, DB::table('follows')
        ->where('follower_user_id', $user1->id)
        ->where('followed_user_id', $user2->id)
        ->count());
}

}