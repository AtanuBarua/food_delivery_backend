<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRestaurantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'logo' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
            'address' => 'required',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'business_licence' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'vat_certificate' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'tax_identification_number' => 'required|string|max:20',
            'bank_statement' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'utility_bill' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'restaurant_menu' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
