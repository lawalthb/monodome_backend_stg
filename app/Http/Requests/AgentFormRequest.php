<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentFormRequest extends FormRequest
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
                'full_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|numeric|min:10|unique:users,phone_number',
                'street' => 'required|string',
               // 'date_of_birth' => 'required|string',
               // 'gender' => 'required|string|in:male,female',
                'nin_number' => 'required|string',
                'business_name' => 'nullable|string',
                // 'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'lga' => 'required|numeric',
                'type' => 'required|string',
                'custom_license_number' => 'required_if:type,clearing',
                'cac_certificate' => 'required_if:type,clearing',
                'other_documents' => 'nullable',
                // 'other_documents' => 'required_if:type,clearing',
                'store_front_image' => 'required_if:type,agent|image|mimes:jpeg,png,jpg|max:2048',
                'inside_store_image' => 'required_if:type,agent|image|mimes:jpeg,png,jpg|max:2048',
                'registration_documents' => 'required_if:type,agent|file|mimes:pdf|max:2048',
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
