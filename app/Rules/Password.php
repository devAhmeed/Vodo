<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Password implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
    // validation logic: password should contain at least a number, a lowercase letter, an uppercase letter, and at least 8 characters
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $value)) {
            //$fail('validation.password')

            $fail(':attribute must contain at least a number, a lowercase letter, an uppercase letter, and at least 8 characters.');

        }
    }
}
