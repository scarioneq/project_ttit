<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Используйте корректные данные при регистрации', 'errors' => $validator->errors()], 422);
        }
        $user = User::create($request->all());
        $token = $user->createToken('MyApp')->plainTextToken;
        return response()->json(['user_token' => $token], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }
        if (Auth::attempt(['email' => 'admin@shop.ru', 'password' => 'QWEasd123'])) {
            $user = Auth::user();
            return $user->createToken('admin_token', ['admin'])->plainTextToken;
        }
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('MyApp')->plainTextToken;
        return response()->json(['user_token' => $token], 201);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
