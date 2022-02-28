<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (! Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $token = Auth::user()->createToken('access_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ], 200);
    }

    public function register(Request $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $user['password'] = bcrypt($user['password']);
        $user = User::create($user);
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
