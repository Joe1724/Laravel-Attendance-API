<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create new user and hash password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Check credentials
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        // Check if the user already has an active token
        if ($user->tokens()->count() > 0) {
            return response()->json([
                'message' => 'User is already logged in.',
            ], 403);
        }

        // Create a new token if no active tokens
        $token = $user->createToken('LaravelSanctum')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'access_token' => $token,
        ], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout the authenticated user.
     */
    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ], 200);
    }
}
