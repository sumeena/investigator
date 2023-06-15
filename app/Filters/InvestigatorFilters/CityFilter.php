<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class CityFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->city)) {
            return $builder->where('city', 'like', '%' . $this->request->city . '%');
        }
        return $builder;
    }
}
