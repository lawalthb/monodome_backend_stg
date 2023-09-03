<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeResource extends FormRequest
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
            'name' => 'required|string|max:255',
            'agent_id' => 'required|integer|exists:agents,id',
            'address' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'status' => 'required|in:active,inactive',
        ];
    }


    public function messages()
    {
        return [
            'agent_id.exists' => 'The selected agent does not exist.',
            'country_id.exists' => 'The selected country does not exist.',
            'state_id.exists' => 'The selected state does not exist.',
        ];
    }
}
