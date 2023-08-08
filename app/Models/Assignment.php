<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users(): BelongsToMany // Investigators
    {
        return $this->belongsToMany(User::class, 'assignment_user');
    }

    public function author(): BelongsTo // Creator
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
