<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorReview extends Model
{
    use HasFactory;

    protected $table   = 'investigator_ratings_and_reviews';
    protected $guarded = ['id'];

    protected $appends = ['report_file_ext'];

    /**
     * Get the investigator that owns the review.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getReportFileExtAttribute()
    {
        return $this->survelance_report ? pathinfo($this->survelance_report, PATHINFO_EXTENSION) : null;
    }
}
