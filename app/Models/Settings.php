<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Settings extends Model
{
    use HasFactory;
        protected $table = 'settings';
        protected $fillable = ['user_id','assignment_invite', 'assignment_hired_or_closed', 'new_message', 'assignment_update','user_role'];
        protected $guarded = ['id'];


}
