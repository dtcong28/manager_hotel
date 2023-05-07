<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
            'name' => ['required', Rule::unique('rooms','name')->ignore($this->room)],
            'type_room_id' => ['required'],
            'status' => ['required'],
            'number_people' => ['required'],
            'size' => ['required'],
            'view' => ['required'],
            'number_bed' => ['required'],
            'rent_per_night' => ['required'],
            'description' => ['required'],
            'images' => ['required'],
        ];
    }
}
