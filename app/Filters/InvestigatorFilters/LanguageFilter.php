<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class LanguageFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->languages) && count($this->request->languages)) {
            return $builder->orWhereHas('investigatorLanguages', function ($query) {
                $query->whereIn('language', $this->request->languages);
            });
        }
        return $builder;
    }
}
