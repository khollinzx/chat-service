<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ChatAppTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_welcome_api(): void
    {
        $response = $this->json('GET','/api/v1/onboard/welcome', ["accept" => "application/json"]);

        Log::alert('f', [$response]);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_sign_in(): string
    {
        $response = $this->json('POST','/api/v1/onboard/signin',
            [
               "phone" => '08188531726',
               'password' => "password",
            ],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json"
            ]);

        Log::alert('token', [$response->json('data')['accessToken']]);
        $response->assertStatus(200);
        $response->assertSeeText("Login succeeded.");
        return $response->json('data')['accessToken'];
    }

    /**
     * A basic feature test example.
     */
    public function test_get_all_registered_user(): void
    {
        $this->faker = Factory::create();
        User::repo()->createModel([
            "name" => $this->faker->name,
            "phone" => $this->faker->phoneNumber,
            'password' => Hash::make($this->faker->password),
        ]);
        $response = $this->json('GET','/api/v1/chats/users/pull?guard=user',
            [],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$this->test_sign_in()
            ]);

        Log::alert('user', [$response]);
        $response->assertStatus(200);
        $response->assertSeeText("all users.");
    }

    /**
     * A basic feature test example.
     */
    public function test_add_user_to_my_contact(): void
    {
        $this->faker = Factory::create();
        $user = User::repo()->createModel([
            "name" => $this->faker->name,
            "phone" => $this->faker->phoneNumber,
            'password' => Hash::make($this->faker->password),
        ]);
        $response = $this->json('POST',"/api/v1/chats/add-to-contact/{$user->getId()}?guard=user",
            [],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$this->test_sign_in()
            ]);

        Log::alert('user', [$response]);
        $response->assertStatus(200);
        $response->assertSeeText("contact saved.");
    }

    /**
     * A basic feature test example.
     */
    public function test_get_my_contacts(): void
    {
        $response = $this->json('GET','/api/v1/chats/my-contacts?guard=user',
            [],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$this->test_sign_in()
            ]);

        Log::alert('user', [$response]);
        $response->assertStatus(200);
        $response->assertSeeText("all user contact.");
    }

    /**
     * A basic feature test example.
     */
    public function test_send_messages(): void
    {
        $chat = Contact::repo()->findByWhere(['owner_id' => 2]);
        $response = $this->json('POST',"/api/v1/chats/{$chat->chat_key}/send?guard=user",
            [
                "message" => "Hello, How are you doing"
            ],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$this->test_sign_in()
            ]);

        Log::alert('user', [$response]);
        $response->assertStatus(200);
        $response->assertSeeText("message sent.");
    }

    /**
     * A basic feature test example.
     */
    public function test_get_my_messages(): void
    {
        $controller = (new Controller());
        $chat = Contact::repo()->findByWhere(['owner_id' => 2]);
        $response = $this->json('GET',"/api/v1/chats/get-my-messages/{$chat->chat_key}?guard=user",
            [],
            [
                "accept" => "application/json",
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$this->test_sign_in()
            ]);

        Log::alert('user', [$response]);
        $response->assertStatus(200);
        $response->assertSeeText("all messages.");
    }
}
