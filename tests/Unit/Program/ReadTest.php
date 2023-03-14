<?php

namespace Tests\Unit\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class ReadTest extends TestCase
{

  public function test_read()
  {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;
    $program = Program::factory()->create(['user_id' => $user->id]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
      'Accept' => 'application/json'
    ])->json('GET', '/api/v1/programs/' . $program->id);

    $response->assertStatus(Response::HTTP_OK);
    $response->assertJsonStructure([
      'data' => [
        'id',
        'type',
        'attributes' => [
          'name',
          'pentesting_start_date',
          'pentesting_end_date',
        ],
        'relationships' => [
          'reports' => [
            'data' => []
          ]
        ]
      ]
    ]);

    $program = Program::where('user_id', $user->id)
      ->where('name', $program->name)
      ->where('pentesting_start_date', $program->pentesting_start_date)
      ->where('pentesting_end_date', $program->pentesting_end_date)
      ->first();

    $this->assertNotNull($program);
  }
}
