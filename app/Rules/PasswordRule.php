<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Check for minimum length
        if (strlen($value) < 5) {
            return false;
        }

        // Check for maximum length
        if (strlen($value) > 10) {
            return false;
        }

        // Check for at least 1 number
        if (!preg_match('/\d/', $value)) {
            return false;
        }

        // Check for at least 2 uppercase letters
        if (preg_match_all('/[A-Z]/', $value) < 2) {
            return false;
        }

        // Check for at least 1 special character
        if (!preg_match('/[^a-zA-Z0-9]/', $value)) {
            return false;
        }

        // If all conditions pass, the validation rule passes
        return true;
    }

    public function message()
    {
        return 'The :attribute must contain minimum 5 to maximum 10 characters, at least 1 number, at least 2 uppercase letters, and at least 1 special character.';
    }
}