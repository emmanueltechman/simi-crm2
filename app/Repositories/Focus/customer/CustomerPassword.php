<?php

namespace App\Repositories\Focus\customer;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 * Class CustomerRepository.
 */
class CustomerPassword implements Rule
{

    public function passes($attribute, $value)
    {
        return Hash::check($value, auth('crm')->user()->password);
    }


    public function message()
    {
        return trans('validation.api.login.username_password_didnt_match');
    }
}
