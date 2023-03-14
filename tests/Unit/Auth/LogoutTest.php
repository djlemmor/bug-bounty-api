<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('API Token')->plainTextToken;
        $response = $this->post('/api/v1/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => get_class($user),
            'tokenable_id' => $user->id,
        ]);
    }
}
