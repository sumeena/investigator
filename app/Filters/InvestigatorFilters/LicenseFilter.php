<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class LicenseFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->license)) {
            return $builder->orWhereHas('investigatorLicenses', function ($query) {
                $query->where('state', $this->request->license);
            });
        }
        return $builder;
    }
}
