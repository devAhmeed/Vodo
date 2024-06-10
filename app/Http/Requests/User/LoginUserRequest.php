<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'=>'required|string|exists:users,username',
            'password'=>'required|string'
        ];
    }

    public function login(){
        $loginUserData = $this->validated();
        $user = User::query()->where('username',$loginUserData['username'])->first();

        if(!$user)return apiResponse(false,__('messages.not_found'),'','user_not_found');

        $credentials = [
        'email'=> $user->email,
        'password'=> $loginUserData['password']
        ];

        if(!auth()->attempt($credentials)) return apiResponse(false,__('messages.invalid_credentials'),'','invalid_credentials');

        $token = $user->createToken('access_token')->plainTextToken;
        $user['access_token'] = $token;

        return apiResponse(true,__('messages.ok'),new UserResource($user));

    }
}
