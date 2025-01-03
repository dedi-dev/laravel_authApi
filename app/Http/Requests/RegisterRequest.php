<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:25',
            'phone_number' => 'required|max_digits:15',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name',
            'name.min' => 'Please enter your name at least 5 character',
            'name.max' => 'Please enter your name max 150 character',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter valid email address',
            'email.unique' => 'This email already used',
            'password.required' => 'Please enter your password',
            'password.min' => 'Please enter your password at least 5 character',
            'password.max' => 'Please enter your password max 15 character',
            'phone_number.required' => 'Please enter your phone_number',
            'phone_number.max_digits' => 'Please enter your phone_number max 15 digits',
        ];
    }
}
