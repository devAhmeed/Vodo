<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\LoginUserRequest;
use App\Http\Requests\Web\User\CreateUserRequest;

class AuthController extends Controller
{
    /**
     * Display Login Page For The User
     */
    public function signIn()
    {
        return view('Users.login');

    }

    /**
     * Display The Signup Page for the user
     */
    public function signUp()
    {
        return view('Users.register');
    }

    /**
     * Store New User
     */
    public function register(CreateUserRequest $request)
    {
        return $request->store();
    }

    /**
     * Authenticate User
     */
    public function login(LoginUserRequest $request)
    {
        return $request->authenticate($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


        /**
     * Logout User
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Logged Out Successfully !');
    }
}
