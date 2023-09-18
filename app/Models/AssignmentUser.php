<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentUser extends Model
{
    use HasFactory;

    protected $table = 'assignment_user';

    protected $guarded = ['id'];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user(): BelongsTo // Investigator
    {
        return $this->belongsTo(User::class);
    }

    public function companyAdminProfile()
    {
        return $this->belongsTo(CompanyAdminProfile::class,'user_id');
    }

    public function chats() {
        return $this->hasMany(Chat::class,'id','investigator_id');
    }

    
}
