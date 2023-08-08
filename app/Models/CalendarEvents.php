<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvents extends Model
{
    use HasFactory;
    protected $table = 'calendar_events';
    public $timestamps = true;

    protected $fillable = ['user_id', 'calendar_id', 'title', 'start_time', 'end_time'];
}
