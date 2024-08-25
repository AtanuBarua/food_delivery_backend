<?php

namespace App\Http\Controllers\Web\Owner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerLoginRequest;
use App\Http\Requests\OwnerRegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(OwnerRegisterRequest $request)
    {
        $data['status'] = false;
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            $data['user'] = (new User())->createOwner($request->all());

            if (!empty($data['user'])) {
                $data['status'] = true;
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

    public function login(OwnerLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $data['status'] = false;
            $status_code = 500;
            $status_message = 'Something went wrong';

            if (Auth::attempt($credentials)) {
                $data['user'] = User::where('email', $request->email)->first();
                $data['status'] = true;
                $status_code = 200;
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

    public function logout(Request $request)
    {
        $status_code = 500;
        $status_message = 'Something went wrong';

        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $status_code = 200;
            $status_message = 'Logged out successfully';
        } catch (\Throwable $th) {
            \Log::error("message", [$th->getMessage()]);
        }

        return response()->json([
            'message' => $status_message
        ], $status_code);
    }
}
