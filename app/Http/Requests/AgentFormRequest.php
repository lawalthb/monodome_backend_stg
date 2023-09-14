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
              //  'new_user' => 'required|string',
                'full_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|string',
                'street' => 'required|string',
                'country_id' => 'required|exists:countries,id',
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
              //  'guarantors.*.address' => 'required|string',
                'guarantors.*.street' => 'required|string',
                'guarantors.*.state' => 'required|string',
                'guarantors.*.lga' => 'required|string',
                'guarantors.*.email' => 'required|email',
                'guarantors.*.profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
               // 'guarantors.*.state_of_residence' => 'required|string',
               // 'guarantors.*.city_of_residence' => 'required|string',
            ];
        }
}
