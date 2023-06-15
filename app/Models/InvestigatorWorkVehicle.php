<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorWorkVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['picture_ext', 'proof_ext'];

    /**
     * Get the investigator that owns the work vehicle.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPictureExtAttribute()
    {
        return $this->picture ? pathinfo($this->picture, PATHINFO_EXTENSION) : null;
    }

    public function getProofExtAttribute()
    {
        return $this->proof_of_insurance ? pathinfo($this->proof_of_insurance, PATHINFO_EXTENSION) : null;
    }
}
