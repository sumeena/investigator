<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyAdminProfile extends Model
{
    use HasFactory;

    protected $table   = 'company_admin_profiles';
    protected $guarded = ['id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function CompanyProfile(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function hmUsers()
    {
        return $this->hasMany(HiringManagerCompany::class);
    }

}
