<?php

namespace Tests\Unit\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{

  public function test_update()
  {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;
    $program = Program::factory()->create(['user_id' => $user->id]);

    $updatedData = [
      'name' => 'Updated Test Program 2',
      'pentesting_start_date' => '2023-03-22',
      'pentesting_end_date' => '2023-03-28'
    ];

    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
      'Accept' => 'application/json'
    ])->putJson('/api/v1/programs/' . $program->id, $updatedData);

    $response->assertStatus(Response::HTTP_ACCEPTED);

    $updatedProgram = Program::find($program->id);

    $this->assertEquals('Updated Test Program 2', $updatedProgram->name);
    $this->assertEquals('2023-03-22', $updatedProgram->pentesting_start_date->format('Y-m-d'));
    $this->assertEquals('2023-03-28', $updatedProgram->pentesting_end_date->format('Y-m-d'));
  }
}
