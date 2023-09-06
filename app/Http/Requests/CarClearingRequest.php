<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarClearingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'load_type_id' => 'required|integer',
            'departure_country' => 'required|integer',
            'destination_country' => 'required|integer',
            'car_type' => 'required|integer',
            'car_model' => 'nullable|string|max:30',
            'car_value' => 'nullable|string|max:30',
            'car_year' => 'required|integer',
            'document' => 'required|integer',
            'comment' => 'nullable|string',
            'is_final' => 'required|in:Yes,No',
            'deliver_from_city' => 'nullable|string|max:20',
            'deliver_to_city' => 'nullable|string|max:20',
            'receiver_name' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'zip_code' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'street' => 'nullable|string|max:30',
            'add_info' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Failed',
        ];
    }
}
