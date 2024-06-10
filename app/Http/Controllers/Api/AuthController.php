<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\CreateUserRequest;

class AuthController extends Controller
{
    public function register (CreateUserRequest $request)
    {
        // Create New User
        return $request->store();
    }


    public function login (LoginUserRequest $request)
    {
        // User Login
        return $request->login();
    }

        public function logout (Request $request)
    {
        // User Logout

        auth()->user()->tokens()->delete();
        return apiResponse(true,__('Logged out successfully'),null);

    }
}
