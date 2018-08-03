<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class longitudeDataRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        return preg_match("/^(?:(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(\.)?(?(1)[0-9]{0,8})|180)$/",$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '您所输入的经度不符合常理，须小于等于180';
    }
}
