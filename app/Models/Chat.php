<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    public $timestamps = true;

    protected $fillable = ['assignment_id', 'company_admin_id', 'investigator_id', 'is_read'];


    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function chatUsers() {
        return $this->hasMany(ChatMessage::class);
    }
}
