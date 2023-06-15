<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class StateFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->state)) {
            return $builder->where('state', 'like', '%' . $this->request->state . '%');
        }
        return $builder;
    }
}
