<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\LoginUserRequest;
use App\Http\Requests\Web\User\CreateUserRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function signIn()
    {
        return view('Users.login');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function signUp()
    {
        return view('Users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(CreateUserRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the specified resource.
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

        /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Logged Out Successfully !');
    }
}
