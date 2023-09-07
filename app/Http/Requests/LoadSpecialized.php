<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadSpecialized extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'load_type_id' => 'required|integer',
            'deliver_from_city' => 'required|integer',
            'deliver_to_city' => 'required|integer',
            'description' => 'required|integer',
            // 'documents' => 'required',
        ];
    }
}
