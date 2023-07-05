<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringManagerCompany extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function hiringManager()
    {
        return $this->belongsTo(User::class, 'hiring_manager_id', 'id');
    }

    public function companyAdmin()
    {
        return $this->belongsTo(User::class, 'company_admin_id', 'id');
    }
}
