<?php

namespace App\Filters\InvestigatorFilters;

use App\Filters\Filter;

class VideoCaptureRateFilter extends Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function applyFilters($builder)
    {
        if (isset($this->request->video_capture_rate)) {
            return $builder->whereHas('investigatorReview', function ($query) {
                $query->where('video_claimant_percentage', $this->request->video_capture_rate);
            });
        }
        return $builder;
    }
}
