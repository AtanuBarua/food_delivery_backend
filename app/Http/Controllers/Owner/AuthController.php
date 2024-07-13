<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

}
