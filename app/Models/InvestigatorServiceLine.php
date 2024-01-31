<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorServiceLine extends Model
{
    use HasFactory;

    protected $table   = 'investigator_service_lines';
    protected $guarded = ['id'];

    protected $appends = ['case_experience_text'];

    /**
     * Get the investigator that owns the service line.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCaseExperienceTextAttribute()
    {
        if ($this->case_experience == 1) {
            $text = 'Under 50';
        } elseif ($this->case_experience == 2) {
            $text = '50-499';
        } else {
            $text = '500+';
        }

        return $text;
    }

    public function investigationType()
    {
        return $this->belongsTo(InvestigatorType::class, 'investigation_type_id');
    }
}
