<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorLanguage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['fluency_text', 'writing_fluency_text'];

    /**
     * Get the investigator that owns the language.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function investigatorLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language', 'id');
    }

    public function getFluencyTextAttribute()
    {
        if ($this->fluency == 1) {
            $text = 'Beginner to Conversational';
        } else {
            $text = 'Moderate to Fluent';
        }
        return $text;
    }

    public function getWritingFluencyTextAttribute()
    {
        if ($this->writing_fluency == 1) {
            $text = 'Conversational';
        } else {
            $text = 'Fluent';
        }
        return $text;
    }
}
