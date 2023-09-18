<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestigatorSearchHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'languages' => 'array',
    ];


    public function user(): BelongsTo // Searched By User
    {
        return $this->belongsTo(User::class);
    }

    public function license(): BelongsTo // License State from state table
    {
        return $this->belongsTo(State::class);
    }

    public function languages(): HasMany // License State from state table
    {
        return $this->hasMany(InvestigatorLanguage::class,'id','languages');
    }
}
