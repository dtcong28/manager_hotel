<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => ['required', Rule::unique('customers','email')->ignore($this->customer)],
            'address' => ['required'],
            'phone' => ['required'],
            'identity_card' => ['required'],
        ];
    }
}
