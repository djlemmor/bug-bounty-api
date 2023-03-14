<?php

namespace Tests\Unit\Program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
  public function test_delete()
  {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;
    $program = Program::factory()->create(['user_id' => $user->id]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
      'Accept' => 'application/json'
    ])->delete('/api/v1/programs/' . $program->id);

    $response->assertStatus(Response::HTTP_NO_CONTENT);

    $deletedProgram = Program::find($program->id);

    $this->assertNull($deletedProgram);
  }
}
