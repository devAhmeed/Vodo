<?php

namespace App\Http\Requests\Web\User;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class CreateUserRequest extends FormRequest
{
    use SanitizesInput;
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
    public function filters()
    {
        return [
            'name' => 'trim|empty_string_to_null|capitalize|escape',
            'username' => 'trim|empty_string_to_null|escape',
            'email' => 'trim|empty_string_to_null|lowercase|escape',
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
            auth()->login($user);
            return redirect('/')->with('message', 'Account Created Successfully and Logged In ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/signup')->with(['errors' => $e->getMessage()]);
        }
    }
}
