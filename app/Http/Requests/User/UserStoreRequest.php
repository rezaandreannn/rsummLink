<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\S*$/u',
                Rule::unique('users', 'name'),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                'regex:/^\+?[0-9]{7,15}$/',
            ],
        ];
    }
}
