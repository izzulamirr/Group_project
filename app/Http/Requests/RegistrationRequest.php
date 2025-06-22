<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow validation
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[A-Za-z]+$/|max:255', // Only A-Z and a-z allowed
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:7|confirmed',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'The name may only contain letters (A-Z and a-z).',
        ];
    }
}