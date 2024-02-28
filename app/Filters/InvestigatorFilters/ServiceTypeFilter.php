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

               $query->when($this->request->has('surveillance'), function($sq) {
                        $sq->where('investigation_type_id', $this->request->surveillance);
                    })
                    ->when($this->request->has('statements'), function($sq) {
                        $sq->where('investigation_type_id', $this->request->statements);
                    })
                    ->when($this->request->has('misc'), function($sq) {
                        $sq->whereNull('investigation_type');
                    });
            //    dd($query->dd());
            });
        }
        return $builder;
    }
}
