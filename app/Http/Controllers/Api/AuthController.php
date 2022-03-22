<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

use App\Models\User;

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
   
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->sendEmailVerificationNotification();

        return response()
            ->json([
                'code' => 200,
                'data' => $user,
                'access_token' => $token, 
                'token_type' => 'Bearer'
            ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json([
                    'code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'code' => 200,
                'user' => $user,
                'access_token' => $token, 
                'token_type' => 'Bearer'
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'code' => 200,
            'message' => 'Success logout from system'
        ];
    }

    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }
    
        $user = User::findOrFail($user_id);
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    
        return [
            'code' => 200,
            'message' => 'Success verify'
        ];
    }
    
    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();

        return [
            'code' => 200,
            'message' => 'Success resend email'
        ];
    }
}
