<?php

namespace App\Rules;

use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;

class CompanyAdminMatchDomain implements Rule
{
    protected $domain;
    protected $role;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($domain, $role)
    {
        $this->domain = $domain;
        $this->role   = $role;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Extract the domain name from the email
        $emailDomain = explode('@', $value)[1];
        $websiteDomain = preg_replace('/^www\./', '', $this->domain);
        // Compare the two domain names
        return !$this->checkIsCompanyAdminRole() || $emailDomain === $websiteDomain;
    }

    /**
     * Check if the role is a company admin.
     * @return bool
     */
    private function checkIsCompanyAdminRole()
    {
        $role = Role::find($this->role);

        $hasCompanyAdminRole = false;

        if ($role && $role->role == 'company-admin') {
            $hasCompanyAdminRole = true;
        }

        return $hasCompanyAdminRole;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email domain must match the domain of the website.';
    }
}
