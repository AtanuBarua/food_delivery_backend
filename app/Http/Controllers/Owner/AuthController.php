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

        try {
            $user = (new User())->createOwner($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json([
            'message'=>'Owner created successfully',
            'user' => $user
        ]);

    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $status_code = 401;

        try {
            if (Auth::attempt($credentials)) {
                $status_code = 200;
                $request->session()->regenerate();
                $user = User::where('email', $request->email)->first();
                return response()->json([
                    'status_code' => $status_code,
                    'message' => 'Logged in successfully',
                    'user' => $user
                ]);
            }
            return response()->json([
                'status_code' => $status_code,
                'message' => 'Incorrect email or password'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' =>'Something went wrong'
            ]);
        }

    }
}
