<?php

namespace Tests\Unit\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{

    public function test_create()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ])->postJson('/api/v1/programs', [
            'name' => 'Test Program',
            'pentesting_start_date' => '2023-03-20',
            'pentesting_end_date' => '2023-03-25'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'id',
            'name',
            'user_id',
            'pentesting_start_date',
            'pentesting_end_date',
            'created_at',
            'updated_at'
        ]);

        $program = Program::where('user_id', $user->id)
            ->where('name', 'Test Program')
            ->where('pentesting_start_date', '2023-03-20')
            ->where('pentesting_end_date', '2023-03-25')
            ->first();

        $this->assertNotNull($program);
    }
}
