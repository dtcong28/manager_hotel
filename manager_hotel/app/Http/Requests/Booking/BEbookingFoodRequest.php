<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class BEbookingFoodRequest extends FormRequest
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
            'meal_time' => ['required', 'after:time_check_in', 'before:time_check_out'],
        ];
    }


    public function messages()
    {
        return [
            'meal_time.after' => 'The meal time must be a date after time check in.',
            'meal_time.before' => 'The meal time must be a date before  time check out.',
        ];
    }
}
