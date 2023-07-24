<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NylasUsers extends Model
{
    use HasFactory;
    protected $table = 'nylas_users';
    public $timestamps = true;
    protected $fillable = ['user_id', 'nylas_id', 'access_token', 'account_id', 'billing_state', 'email_address', 'linked_at', 'name', 'object', 'organization_unit', 'provider', 'sync_state'];
}
