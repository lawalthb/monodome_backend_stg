<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverMangerRequest extends FormRequest
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
            //'full_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'street' => 'required|string',
            'business_name' => 'nullable|string',
            // 'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'lga' => 'required|numeric',
            // 'state_of_residence' => 'required|string',
            // 'city_of_residence' => 'required|string',
            'office_front_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'inside_office_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cac_certificate' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'guarantors' => 'required|array',
            'guarantors.*.full_name' => 'required|string',
            'guarantors.*.phone_number' => 'required|string',
            'guarantors.*.street' => 'required|string',
            'guarantors.*.state' => 'required|numeric',
            'guarantors.*.lga' => 'required|numeric',
            'guarantors.*.email' => 'required|email',
            'guarantors.*.profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}