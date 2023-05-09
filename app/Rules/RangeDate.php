<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

/**
 * @SuppressWarnings(unused)
 */
class RangeDate implements Rule
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
     */
    public function passes($attribute, $value)
    {
        $dates = explode(',', $value);
        if (count($dates) != 2) {
            return false;
        }

        foreach ($dates as $date) {
            try {
                Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must consist of two dates in Y-m-d format. Example: 2021-08-26';
    }
}
