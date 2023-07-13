<?php

namespace App\Http\Requests\Investigator;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
        // 'password'    => 'required|confirmed|min:8|max:10',
        'password'   => ['required', 'string', 'min:10', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&()]{10,}$/']
      ];
    }

    public function messages(): array
    {
      return [
        // 'password'    => 'required|confirmed|min:8|max:10',
        'password.regex' => 'Password is invalid, please follow the instructions below!'
      ];
    }
}
