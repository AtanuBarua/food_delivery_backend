<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10',
            'password' => 'required|min:6',
        ]);

        $data = [];
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $data['user'] = (new User())->createOwner($request->all());

            if (!empty($data['user'])){
                $data['token'] = $data['user']->createToken('auth_token')->plainTextToken;
                $status_message = "Owner created successfully";
                $status_code = 200;
            }
        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message,
            'data' => $data
        ], $status_code);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $data = [];
            $status_code = 500;
            $status_message = 'Something went wrong';

            if (Auth::attempt($credentials)) {
                $data['user'] = User::where('email', $request->email)->first();
                $data['token'] = $data['user']->createToken('auth_token')->plainTextToken;
                $status_message = 'Logged in successfully';
            } else {
                $status_message = 'Incorrect email or password';
            }

        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message,
            'data' => $data
        ], $status_code);
    }

    public function logout(Request $request) {
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $request->user()->tokens()->delete();
                $status_message = 'Logged out successfully';
        } catch (\Throwable $th) {
            \Log::warning("message",[$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message
        ], $status_code);
    }
}
