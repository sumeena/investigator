<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorDocument extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['dl_ext', 'passport_ext', 'ssn_ext', 'brc_ext', 'form_19_ext'];

    /**
     * Get the investigator that owns the document.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDlExtAttribute()
    {
        return $this->driving_license ? pathinfo($this->driving_license, PATHINFO_EXTENSION) : null;
    }

    public function getPassportExtAttribute()
    {
        return $this->passport ? pathinfo($this->passport, PATHINFO_EXTENSION) : null;
    }

    public function getSsnExtAttribute()
    {
        return $this->ssn ? pathinfo($this->ssn, PATHINFO_EXTENSION) : null;
    }

    public function getBrcExtAttribute()
    {
        return $this->birth_certificate ? pathinfo($this->birth_certificate, PATHINFO_EXTENSION) : null;
    }

    public function getForm19ExtAttribute()
    {
        return $this->form_19 ? pathinfo($this->form_19, PATHINFO_EXTENSION) : null;
    }
}
