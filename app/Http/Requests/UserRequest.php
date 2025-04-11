<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/|min:8|max:255|confirmed',
            'phone' => 'required|min:9|max:15',
            'profile_pic' => 'image',
            'address_one' => 'nullable|min:10|max:500',
            'address_two' => 'nullable|min:10|max:500',
            'city' => 'nullable|min:10|max:255',
            'state_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
        ];
    }

    public function messages(): array
{
    return [
        'first_name.required' => 'First Name field is required',
        'first_name.max' => 'First Name field support 255 characters',
        'last_name.required' => 'Last Name field is required',
        'last_name.max' => 'Last Name field support 255 characters',
    ];
}
}
