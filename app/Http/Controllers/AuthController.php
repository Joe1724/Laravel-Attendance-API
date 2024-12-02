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

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create new user and hash password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return response
        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
        ], 201);
    }

    /**
     * Login and return access token.
     */
    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Check if credentials are correct
        if (Auth::attempt($request->only('email', 'password'))) {
            // Generate token for the user
            $user = Auth::user();
            $token = $user->createToken('LaravelSanctum')->plainTextToken;

            // Return response with token
            return response()->json([
                'message' => 'Login successful.',
                'access_token' => $token,
            ], 200);
        }

        // Invalid credentials response
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Get the authenticated user's details.
     */
    public function user(Request $request)
    {
        // Return authenticated user's details
        return response()->json($request->user());
    }
}
