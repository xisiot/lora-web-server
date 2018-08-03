<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AppEUIRule implements Rule
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
        return preg_match("/^[0-9a-fA-F]{16}$/",$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '您未选择正确的AppEUI，或许您需要先注册一个应用，再来注册设备';
    }
}
