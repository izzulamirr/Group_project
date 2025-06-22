<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow validation
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email', // Validate email format
            'password' => 'required|string',
        ];
    }
}