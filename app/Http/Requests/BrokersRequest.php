<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrokersRequest extends FormRequest
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
            'phone_number' => 'required|string|unique:users,phone_number',
            'street' => 'required|string',
            'state_id' => 'required|exists:states,id',
            'lga' => 'required|string',
            'nin_number' => 'required|string',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
