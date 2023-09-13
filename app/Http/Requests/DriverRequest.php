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
              'type_of_truck' => 'required|exists:countries,id',
              'state_id' => 'required|exists:states,id',
              'lga' => 'required|string',
              'state_of_residence' => 'required|string',
              'city_of_residence' => 'required|string',
              'store_front_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'inside_store_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
              'registration_documents' => 'required|file|mimes:pdf|max:2048',
              'guarantors' => 'required|array',
              'guarantors.*.full_name' => 'required|string',
              'guarantors.*.phone_number' => 'required|string',
              'guarantors.*.address' => 'required|string',
              'guarantors.*.street' => 'required|string',
              'guarantors.*.state' => 'required|string',
              'guarantors.*.lga' => 'required|string',
              'guarantors.*.state_of_residence' => 'required|string',
              'guarantors.*.city_of_residence' => 'required|string',
              'guarantors.*.profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
          ];
    }
}
