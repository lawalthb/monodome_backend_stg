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
        $rules = [
            'full_name' => 'required|string',
            'email' => 'required|email',
          //  'isNew' => 'required|in:Yes,No',
            'phone_number' => 'required|numeric|min:10|unique:users,phone_number',
            'street' => 'required|string',
            'date_of_birth' => 'required|string',
            'gender' => 'required|string|in:male,female',
            'state_id' => 'required|exists:states,id',
            'lga' => 'required|string',
            'nin_number' => 'required|string',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // Check if 'password' exists in the request, then add the validation rule
        if ($this->has('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }
}
