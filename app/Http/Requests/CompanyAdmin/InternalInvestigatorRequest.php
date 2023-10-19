<?php

namespace App\Http\Requests\CompanyAdmin;

use Illuminate\Foundation\Http\FormRequest;

class InternalInvestigatorRequest extends FormRequest
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
        $rules = [
            'first_name' => 'bail|required|string|max:20',
            'last_name'  => 'bail|required|string|max:20',
            'email'      => ['bail', 'required', 'string', 'email', 'unique:users,email'],
            'password'   => ['bail', 'required_if:submit_type,=,add', 'string', 'min:10', 'confirmed']
        ];
        if ($this->submit_type == 'edit') {
            unset($rules['email']);
            $rules['password'] = ['bail', 'nullable', 'string', 'min:10', 'confirmed'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'password.required_if' => 'The password is required.'
        ];
    }
}
