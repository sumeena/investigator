<?php

namespace App\Http\Requests\CompanyAdmin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAdminProfileRequest extends FormRequest
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
            'company_name'  => 'bail|required',
            'company_phone' => 'bail|required|digits:10',
            'address'       => 'bail|required',
            'city'          => 'bail|required',
            'state'         => 'bail|required',
            'country'       => 'bail|required',
            'zipcode'       => 'bail|required',
            'timezone'      => 'bail|required|exists:timezones,id',
        ];
    }

}
