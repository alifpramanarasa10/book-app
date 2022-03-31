<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 3
        ]);

        $token = $user->createToken($request->email)->plainTextToken;
        $user->sendEmailVerificationNotification();

        return response()->json([
            'code' => 200,
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Success create user'
        ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json([
                'code' => 422,
                'message' => 'Wrong username or password!'
            ], 422);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'code' => 200,
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Success login to system'
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Success logout from system'
        ]);
    }

    public function verify($userId, Request $request)
    {
        if(!$request->hasValidSignature())
        {
            return response()->json([
                'code' => 422,
                'message' => "Invalid signature"
            ], 422);
        }

        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'code' => 200,
            'message' => 'Success verify user'
        ]);
    }

    public function resend(Request $request)
    {      
        $user = User::find($request->id);
        if($user->hasVerifiedEmail())
        {
            return response()->json([
                'code' => 422,
                'message' => 'Email already verified'
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'code' => 200,
            'message' => 'Success resend email'
        ]);
    }
}
