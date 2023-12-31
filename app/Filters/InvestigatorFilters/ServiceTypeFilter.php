<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class ServiceTypeFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->statements) || isset($this->request->surveillance) || isset($this->request->misc)) {
            return $builder->whereHas('investigatorServiceLines', function ($query) {
//                dd($this->request->all());
                $query->where('investigation_type', $this->request->surveillance)
                    ->orWhere('investigation_type', $this->request->statements)
                    ->orWhere('investigation_type', $this->request->misc);
//                dd($query->toSql());
            });
        }
        return $builder;
    }
}
