<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckFormRequest extends FormRequest
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
        'business_name' => 'required|string',
        'phone_number' => 'required|string|unique:truck_owners,phone_number',
        'email' => 'required|email|unique:users,email',
        'street' => 'required|string',
        'date_of_birth' => 'required|string',
        'gender' => 'required|string|in:male,female',
        'state_id' => 'required|exists:states,id',
        'lga' => 'required|numeric',
        'truck_name' => 'required|string',
        'truck_type' => 'required|string',
        'truck_location' => 'required|string',
        'truck_make' => 'required|string',
        'plate_number' => 'required|string',
        'cac_number' => 'nullable|string',
        'truck_description' => 'nullable|string',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'outside_truck_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'truck_document' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ];
    }
}
