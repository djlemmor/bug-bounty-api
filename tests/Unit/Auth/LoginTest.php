<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]
        ]);

        $token = $response->json('token');
        $this->assertTrue($user->tokens->contains('plain_text_token', $token));
    }
}
