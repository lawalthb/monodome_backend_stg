<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingCompanyRequest extends FormRequest
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
              'email' => 'required|email|email',
              'phone_number' => 'required|string',
              'street' => 'required|string',
              'company_name' => 'required|string',
              'state_id' => 'required|exists:states,id',
              'lga' => 'required|numeric',
              'profile_picture' => 'required|mimes:jpeg,png,jpg|max:2048',
              'guarantors_full_name' => 'required|string',
              'guarantors_phone_number' => 'required|string',
              'guarantors_street' => 'required|string',
              'guarantors_state' => 'required|numeric',
              'guarantors_lga' => 'required|numeric',
              'guarantors_profile_picture' => 'required|mimes:jpeg,png,jpg|max:2048',
              // 'guarantors_address' => 'required|string',
              //  'guarantors_state_of_residence' => 'required|string',
              //'guarantors_city_of_residence' => 'required|string',
          ];
    }
}
