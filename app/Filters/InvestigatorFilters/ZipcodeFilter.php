<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class ZipcodeFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->zipcode)) {
            return $builder->where('zipcode', 'like', '%' . $this->request->zipcode . '%');
        }
        return $builder;
    }
}
