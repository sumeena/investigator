<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorLicense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['insurance_file_ext', 'bonded_file_ext'];

    /**
     * Get the investigator that owns the license.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state_data()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    public function getInsuranceFileExtAttribute()
    {
        return $this->insurance_file ? pathinfo($this->insurance_file, PATHINFO_EXTENSION) : null;
    }

    public function getBondedFileExtAttribute()
    {
        return $this->bonded_file ? pathinfo($this->bonded_file, PATHINFO_EXTENSION) : null;
    }
}
