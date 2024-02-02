<?php

namespace App\Http\Requests\CompanyAdmin;

use Illuminate\Validation\Rules\RequiredIf;
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
            'password'   => ['bail', 'required_if:submit_type,=,add', 'string', 'min:10', 'confirmed'],
            
            
            'investigation_type'                    => 'bail|required|array|min:1',
            'investigation_type.0.case_experience'  => [new RequiredIf(isset($this->investigation_type[0]['type']))],
            'investigation_type.0.years_experience' => [new RequiredIf(isset($this->investigation_type[0]['type']))],
            'investigation_type.0.hourly_rate'      => [new RequiredIf(isset($this->investigation_type[0]['type']))],
            'investigation_type.0.travel_rate'      => [new RequiredIf(isset($this->investigation_type[0]['type']))],
            'investigation_type.0.milage_rate'      => [new RequiredIf(isset($this->investigation_type[0]['type']))],
            'investigation_type.1.case_experience'  => [new RequiredIf(isset($this->investigation_type[1]['type']))],
            'investigation_type.1.years_experience' => [new RequiredIf(isset($this->investigation_type[1]['type']))],
            'investigation_type.1.hourly_rate'      => [new RequiredIf(isset($this->investigation_type[1]['type']))],
            'investigation_type.1.travel_rate'      => [new RequiredIf(isset($this->investigation_type[1]['type']))],
            'investigation_type.1.milage_rate'      => [new RequiredIf(isset($this->investigation_type[1]['type']))],
            'investigation_type.2.case_experience'  => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            'investigation_type.2.years_experience' => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            'investigation_type.2.hourly_rate'      => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            'investigation_type.2.travel_rate'      => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            'investigation_type.2.milage_rate'      => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            'investigation_type.2.misc_service_name' => [new RequiredIf(isset($this->investigation_type[2]['type']))],
            
            'investigation_type.2.case_experience.*'  => 'bail|required',
            'investigation_type.2.years_experience.*' => 'bail|required',
            'investigation_type.2.hourly_rate.*'      => 'bail|required',
            'investigation_type.2.travel_rate.*'      => 'bail|required',
            'investigation_type.2.milage_rate.*'      => 'bail|required',
            'investigation_type.2.misc_service_name.*' => 'bail|required|distinct',


        ];
        if ($this->submit_type == 'edit') {
            unset($rules['email']);
            $rules['password'] = ['bail', 'nullable', 'string', 'min:10', 'confirmed'];
        }

        return $rules;
    }



    public function attributes()
    {
        return [
            'investigation_type.0.case_experience'  => 'case experience',
            'investigation_type.0.years_experience' => 'years experience',
            'investigation_type.0.hourly_rate'      => 'hourly rate',
            'investigation_type.0.travel_rate'      => 'travel rate',
            'investigation_type.0.milage_rate'      => 'mileage rate',
            'investigation_type.1.case_experience'  => 'case experience',
            'investigation_type.1.years_experience' => 'years experience',
            'investigation_type.1.hourly_rate'      => 'hourly rate',
            'investigation_type.1.travel_rate'      => 'travel rate',
            'investigation_type.1.milage_rate'      => 'mileage rate',
            'investigation_type.2.case_experience'  => 'case experience',
            'investigation_type.2.years_experience' => 'years experience',
            'investigation_type.2.hourly_rate'      => 'hourly rate',
            'investigation_type.2.travel_rate'      => 'travel rate',
            'investigation_type.2.milage_rate'      => 'mileage rate',
            'investigation_type.2.misc_service_name.*' => 'misc service name',
            'investigation_type.2.case_experience.*'  => 'misc case experience',
            'investigation_type.2.years_experience.*' => 'misc years experience',
            'investigation_type.2.hourly_rate.*'      => 'misc hourly rate',
            'investigation_type.2.travel_rate.*'      => 'misc travel rate',
            'investigation_type.2.milage_rate.*'      => 'misc mileage rate',

        ];
    }

    public function messages()
    {
        return [
            'password.required_if' => 'The password is required.'
        ];
    }
}
