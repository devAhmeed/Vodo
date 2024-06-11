<?php

namespace App\Http\Requests\Api\User;

use App\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username'=>['required' , 'string' , Rule::unique('users')->ignore(auth()->user()->id)],
            'email'=>['required' , 'string' , 'email' , Rule::unique('users')->ignore(auth()->user()->id)],
            'password'=>['required' , 'string' , new Password],
        ];
    }



    public function update(){
        DB::beginTransaction();
        try {
            $data = $this->validated();
            $data['password'] = bcrypt($data['password']);
            $user = auth()->user();
            if (!auth()->user()) return apiResponse(false, __('user.not_found'), null, 'bad_request');
            $user->update($data);
            $user->refresh();
            \DB::commit();
            return apiResponse(true, __('user.updated'), new UserResource($user),'ok');
        } catch (\Exception $e) {
            \DB::rollBack();
            return apiResponse(false, __('user.error'), null, 'bad_request');
        }
    }
}
