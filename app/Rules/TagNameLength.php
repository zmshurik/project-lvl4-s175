<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagNameLength implements Rule
{
    private const MAX_LENGTH = 15;
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $names = collect(explode(',', $value));
        return $names->every(function ($name, $key) {
            return strlen($name) <= self::MAX_LENGTH;
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Max tag name length is 15 characters';
    }
}
