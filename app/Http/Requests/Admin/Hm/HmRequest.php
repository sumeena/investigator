<?php

namespace App\Http\Requests\Admin\Hm;

use App\Models\Role;
use App\Models\User;
use App\Rules\CompanyAdminMatchDomain;
use App\Rules\CompanyHmMatchDomain;
use Illuminate\Foundation\Http\FormRequest;

class HmRequest extends FormRequest
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
        $website = User::find($this->company_admin)->website ?? null;
        $role = Role::where('role', 'hiring-manager')->first()->id;
        return [
            'first_name' => 'required|max:20',
            'last_name'  => 'required|max:20',
            'email'      => ['required','email','unique:users,email,'. $this->id, new CompanyHmMatchDomain($website, $role)],
            'phone'      => 'required|digits:10',
        ];
    }
}
