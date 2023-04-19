<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
            'role' => 'required|in:admin,user',
        ]);
    
        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->save();
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
