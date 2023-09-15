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
              'have_motor' => 'nullable|in:No,Yes',
              'full_name' => 'required|string',
              'email' => 'required|email|unique:users,email',
              'phone_number' => 'required|string',
              'street' => 'required|string',
              'vehicle_type_id' => 'required|exists:vehicle_types,id',
              'state_id' => 'required|exists:states,id',
              'lga' => 'required|string',
              'nin_number' => 'required|string',
              'license_number' => 'required|string',
              'proof_of_license' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'vehicle_image' => 'required|array',
              'guarantors' => 'required|array',
              'guarantors.*.full_name' => 'required|string',
              'guarantors.*.phone_number' => 'required|string',
              'guarantors.*.street' => 'required|string',
              'guarantors.*.state' => 'required|string',
              'guarantors.*.lga' => 'required|string',
              'guarantors.*.profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
          ];
    }
}
