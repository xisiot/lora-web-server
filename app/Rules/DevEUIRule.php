<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DevEUIRule implements Rule
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
        return '您所输入的LoRa设备唯一标识符（DevEUI）不是正确的8字节数';
    }
}
