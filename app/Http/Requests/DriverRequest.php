<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
              'have_motor' => 'required|in:No,Yes',
              'full_name' => 'required|string',
              'email' => 'required|email',
              'phone_number' => 'required|numeric|min:10|unique:users,phone_number',
              'street' => 'required|string',
              'date_of_birth' => 'required|string',
              'gender' => 'required|string|in:male,female',
              'vehicle_type_id' => 'required_if:have_motor,Yes',
              'state_id' => 'required|exists:states,id',
              'lga' => 'required|string',
              'nin_number' => 'nullable|string',
              'license_number' => 'required|string',
              'proof_of_license' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'vehicle_image' => 'required_if:have_motor,Yes|array',
              'guarantors' => 'nullable|array',
              'guarantors.*.full_name' => 'nullable|string',
              'guarantors.*.phone_number' => 'nullable|string',
              'guarantors.*.street' => 'nullable|string',
              'guarantors.*.state' => 'nullable|string',
              'guarantors.*.lga' => 'nullable|string',
              'guarantors.*.profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
          ];
    }
}
