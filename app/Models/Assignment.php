<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users(): BelongsToMany // Investigators
    {
        return $this->belongsToMany(User::class, 'assignment_user')->withPivot('hired');
    }

    // public function investigator() // Investigator
    // {
    //     return $this->users()->latest();
    // }

    public function author(): BelongsTo // Creator
    {
        return $this->belongsTo(User::class, 'user_id');
    } 

    public function companyAdminProfile(): BelongsTo
    {
        return $this->BelongsTo(User::class,'id', 'user_id' );
    }

    /* public function invitations() {
        return $this->hasMany(Invitation::class);
    } */

    public function searchHistory() {
        return $this->belongsTo(InvestigatorSearchHistory::class,'id', 'assignment_id');
    }

    public function chats() {
        return $this->hasMany(Chat::class);
    }

}
