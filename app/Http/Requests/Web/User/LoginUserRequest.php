<?php

namespace App\Http\Requests\Web\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class LoginUserRequest extends FormRequest
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
            'username'=>'required|string|exists:users,username',
            'password'=>'required|string'
        ];
    }

        public function filters()
    {
        return [
            'username' => 'trim|empty_string_to_null|escape',
        ];
    }


    public function authenticate(Request $request) {
        $data = $this->validated();
        $user = User::query()->where('username', $data['username'])->first();
        $userCredentials = ['email' => $user->email, 'password' => $data['password']];

        if (auth()->attempt($userCredentials)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', "You Have Successfully Logged In");
        }

        return back()->withErrors(['password' => 'Invalid Credentials'])->onlyInput('password');

    }
}
