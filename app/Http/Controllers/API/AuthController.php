<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(RegisterRequest $request) {

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name),
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token of '.$user->name)->plainTextToken;

        return $this->success(new UserResource($user), 'User Created Successfully.',201);
    }

    public function login(LoginRequest $request) {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email','password']))) {
            return $this->error('Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token of '.$user->name)->plainTextToken;

        return $this->success([
            'token' => $token,
        ], 'Login Successful.');
    }

    public function get_user() {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return $this->success(null, 'Successfully logged out user.');
    }
}
