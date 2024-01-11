<?php

namespace App\Http\Requests\Investigator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class InvestigatorProfileRequest extends FormRequest
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
            'phone'                                 => 'bail|required|digits:10',
            'address'                               => 'bail|required',
            'city'                                  => 'bail|required',
            'state'                                 => 'bail|required',
            'country'                               => 'bail|required',
            'zipcode'                               => 'bail|required',
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
            'video_claimant_percentage'             => 'bail|required',
            'survelance_report'                     => 'bail|nullable|mimes:jpeg,png,jpg,pdf,doc,docx|max:20000',
            'camera_type'                           => 'bail',
            'camera_model_number'                   => 'bail',
            /*'licenses'                              => 'bail|required|array|min:1',
            'licenses.*.state'                      => 'bail|required',
            'licenses.*.license_number'             => 'bail|required|string',
            'licenses.*.expiration_date'            => 'required',*/
            'work_vehicles'                         => 'bail|required|array|min:1',
            'work_vehicles.*.make'                  => 'bail|required|string',
            'work_vehicles.*.model'                 => 'bail|required|string',
            'work_vehicles.*.year'                  => 'bail|required',
            'work_vehicles.*.picture'               => 'bail|nullable|image|max:5000',
            'work_vehicles.*.insurance_company'     => 'bail|required',
            'work_vehicles.*.policy_number'         => 'bail|required',
            'work_vehicles.*.expiration_date'       => 'bail|required',
            'work_vehicles.*.proof_of_insurance'    => 'bail|nullable|mimes:jpeg,png,jpg,pdf,doc,docx|max:20000',
            'languages'                             => 'bail|required|array|min:1',
            'languages.*.language'                  => 'bail|required|integer',
            'languages.*.fluency'                   => 'bail|required|integer',
            'languages.*.writing_fluency'           => 'bail|required|integer',
            'document_dl'                           => 'bail|nullable|image',
            'document_id'                           => 'bail|nullable|image',
            'document_ssn'                          => 'bail|nullable|image',
            'document_birth_certificate'            => 'bail|nullable|image',
            'document_form_19'                      => 'bail|nullable|image',
            'availability_days'                     => 'bail|required',
            'availability_hours'                    => 'bail|required',
            'availability_distance'                 => 'bail|required',
            'timezone'                              => 'bail|required|exists:timezones,id',
        ];
    }

    public function attributes()
    {
        return [
            'investigation_type.0.case_experience'  => 'case experience',
            'investigation_type.0.years_experience' => 'years experience',
            'investigation_type.0.hourly_rate'      => 'contractor hourly rate',
            'investigation_type.0.travel_rate'      => 'contractor travel rate',
            'investigation_type.0.milage_rate'      => 'contractor mileage rate',
            'investigation_type.1.case_experience'  => 'case experience',
            'investigation_type.1.years_experience' => 'years experience',
            'investigation_type.1.hourly_rate'      => 'contractor hourly rate',
            'investigation_type.1.travel_rate'      => 'contractor travel rate',
            'investigation_type.1.milage_rate'      => 'contractor mileage rate',
            'investigation_type.2.case_experience'  => 'case experience',
            'investigation_type.2.years_experience' => 'years experience',
            'investigation_type.2.hourly_rate'      => 'contractor hourly rate',
            'investigation_type.2.travel_rate'      => 'contractor travel rate',
            'investigation_type.2.milage_rate'      => 'contractor mileage rate',
            'licenses.*.state'                      => 'state',
            'licenses.*.license_number'             => 'license number',
            'licenses.*.expiration_date'            => 'expiration date',
            'licenses.*.insurance_file'             => 'insurance file',
            'licenses.*.bonded_file'                => 'bonded file',
            'work_vehicles.*.make'                  => 'make',
            'work_vehicles.*.model'                 => 'model',
            'work_vehicles.*.year'                  => 'year',
            'work_vehicles.*.picture'               => 'picture',
            'work_vehicles.*.insurance_company'     => 'insurance company',
            'work_vehicles.*.policy_number'         => 'policy number',
            'work_vehicles.*.expiration_date'       => 'expiration date',
            'work_vehicles.*.proof_of_insurance'    => 'proof of insurance',
            'languages.*.language'                  => 'language',
            'languages.*.fluency'                   => 'speaking fluency',
            'languages.*.writing_fluency'           => 'writing fluency',
        ];
    }
}
