<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class DistanceFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->lat) && isset($this->request->lng)) {
            return $builder->whereColumn('investigator_availabilities.distance', '>=', 'calculated_distance');
        }

        return $builder;
    }
}
