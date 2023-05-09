<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UpperCaseExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(?=.*?[A-Z]).*$/', $value) == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must contains at least one uppercase letter.';
    }
}
