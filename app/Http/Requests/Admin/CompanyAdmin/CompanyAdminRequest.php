<?php

namespace App\Http\Requests\Admin\CompanyAdmin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAdminRequest extends FormRequest
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
        'first_name'         => 'required|max:20',
        'last_name'          => 'required|max:20',
        'email'              => 'required|email|unique:users,email,'.$this->id,
        'phone'              => 'required|digits:10',
      ];
    }
}
