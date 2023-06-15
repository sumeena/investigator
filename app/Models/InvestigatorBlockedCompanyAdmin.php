<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorBlockedCompanyAdmin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investigator_id', 'id');
    }

    public function companyAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_admin_id', 'id');
    }
}
