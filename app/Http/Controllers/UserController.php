<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        // This retrieves all users
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $id,
        'password' => 'sometimes|required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the user by ID
    $user = User::findOrFail($id);

    // Extract only the fields provided in the request
    $data = $request->only(['name', 'email', 'password']);

    // Check if password is provided, and hash it
    if (array_key_exists('password', $data)) {
        $data['password'] = bcrypt($data['password']);
    }

    // Update the user attributes
    $user->fill($data); // Fills the model with data
    if ($user->isDirty()) { // Check if there are changes
        $user->save(); // Save only if there are changes
    } else {
        return response()->json(['message' => 'No changes detected'], 200);
    }

    return response()->json(['message' => 'User updated successfully', 'user' => $user]);
}






    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
