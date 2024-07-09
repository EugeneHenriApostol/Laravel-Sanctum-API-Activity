<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return response()->json($user, 201);
    // }
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            if ($validateUser->fails()) {
                return response()->json([
                    'error' => $validateUser->errors()
                ], 422);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "user" => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'error' => 'Registration Failed!'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if(!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'error' => 'Login Failed'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(null, 204);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'error' => 'Logout Failed',
            ], 500);
        }
    }

    //     // $email = 'user@domain.com';
    //     if($request->generate_email || ($request->email && $request->generate_email)){
    //         $email = fake()->unique()->safeEmail();
    //     } else {
    //     $email = $request->email;
    // }
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $email,
    //         'password' => Hash::make($request->password),
    //     ]);
    //     return response()->json($user, 201);

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (! $user || ! Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect.'],
    //         ]);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json(null, 204);
    // }
}

