<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ], 'Request was successful.');
        }

        return $this->error(null, 'Error has occured.', 400);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error(null, 'Invalid credentials!', 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ], 'Login successful!');
        }

        return $this->error(null, 'Error has occured.', 400);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->success(null, 'You have successfully been logged out!');
    }
}
