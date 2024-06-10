<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'=>'required|string',
            'username'=>'required|string|unique:users',
            'email'=>'required|string|email|unique:users',
            'password'=> ['required' , 'string' , new Password]
        ];
    }

    public function store()
    {
        DB::beginTransaction();
        try{
            $data = $this->validated();
            $data['password'] = bcrypt($data['password']);
            $user = User::query()->create($data);
            DB::commit();
            return apiResponse(true,__('messages.created'),new UserResource($user));
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false,__('messages.error'),null,'bad_request');
        }
    }

}
