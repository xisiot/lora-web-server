<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class latitudeDataRule implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^(?:(?:[0-9]|[1-8][0-9])(\.)?(?(1)[0-9]{0,8})|90)$/",$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '您所输入的纬度不符合常理，须小于等于90';
    }
}
