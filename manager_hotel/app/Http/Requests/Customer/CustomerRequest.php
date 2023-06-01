<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'address' => ['required'],
            'gender' => ['required'],
            'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/', 'min:9'],
            'email' => ['required', Rule::unique('customers','email')->ignore($this->customer)],
            'identity_card' => ['required'],
            'password' => ['confirmed'],
        ];
    }
}
