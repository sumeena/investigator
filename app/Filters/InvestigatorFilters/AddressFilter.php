<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class AddressFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->address)) {
            return $builder->where('address', 'like', '%' . $this->request->address . '%');
        }
        return $builder;
    }
}
