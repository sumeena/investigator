<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAuthUsers extends Model
{
    use HasFactory;
    protected $table = 'google_auth_users';
    public $timestamps = true;

    protected $fillable = ['user_id', 'access_token', 'refresh_token', 'token_type', 'id_token', 'scope', 'expires_in' ];
}
