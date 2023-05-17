<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class FEbookingRequest extends FormRequest
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
            'gender' => ['required'],
//            'email' => ['required', Rule::unique('customers','email')->ignore($this->customer)->whereNull('deleted_at')],
            'email' => ['required', 'email:rfc'],
            'address' => ['required'],
            'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/', 'min:9'],
            'identity_card' => ['required'],
            'password' => ['confirmed'],
        ];
    }
}
