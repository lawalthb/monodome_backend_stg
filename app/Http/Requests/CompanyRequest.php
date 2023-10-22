<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'company_name' => 'required|string',
            'email' => 'required|email|email',
            'phone_number' => 'required|numeric|min:10',
            'street' => 'required|string',
            'state_id' => 'required|exists:states,id',
            'lga' => 'required|numeric',
            'number_of_trucks' => 'required|numeric',
            'number_of_drivers' => 'required|numeric',
            'type_of_truck' => 'required|numeric',
            'state_of_residence' => 'required|string',
            'city_of_residence' => 'required|string',
            'cac_documents' => 'required|file|mimes:pdf|max:2048',
        ];
    }
}
