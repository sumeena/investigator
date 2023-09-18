<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    use HasFactory;
    protected $table = 'chat_messages';
    public $timestamps = true;

    protected $fillable = ['user_id', 'chat_id', 'content', 'media_id', 'type', 'is_delete'];

    public function chat() {
        return $this->belongsTo(Chat::class);
    }

    public function media() {
        return $this->hasMany(Media::class,'id','media_id');
    }
}
