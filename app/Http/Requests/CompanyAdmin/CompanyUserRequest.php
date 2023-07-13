<?php

namespace App\Http\Requests\CompanyAdmin;

use App\Models\Role;
use App\Models\User;
use App\Rules\CompanyAdminMatchDomain;
use App\Rules\CompanyHmMatchDomain;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUserRequest extends FormRequest
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
        $website = User::find(auth()->user()->id)->website ?? User::with('companyAdmin.company')->find(auth()->user()->id)?->parentCompany?->company?->website;

        return [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => ['required','email','unique:users,email', new CompanyAdminMatchDomain($website, $this->role)],
            'phone' => 'required|digits:10',
            'role' => 'required|integer|exists:roles,id'
        ];
    }
}
