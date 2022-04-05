<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_user()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(404);
    }

    public function test_show_user()
    {
        $response = $this->get('/api/users/1');

        $response->assertStatus(404);
    }

    public function test_login()
    {
        $userData = [
            "email" => "alifpramanarasa@gmail.com",
            "password" => "12345678"
        ];

        $this->json('POST', 'api/login', $userData, [
            'Accept' => 'application/json',
            'x-api-key' => env('API_KEY')
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "data" => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'role_id'
                ],
                "access_token",
                "token_type",
                "message"
            ]);
    }
}
