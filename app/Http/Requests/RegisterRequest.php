<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => [
                'required',
                'numeric',
                Rule::notIn([1, 2]), // This rule ensures that the value is not 1 or 2
            ],
            // 'role' => 'required|in:customer,broker,shipping_company,agent,clearing_forwarding,driver,driver_manager,company_transporter',
        ];
    }
}
