<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigatorType extends Model
{
    use HasFactory;
    protected $table = 'investigation_types';

    protected $fillable = [
        'type_name'
    ];

    public function investigationServiceLines()
    {
        return $this->hasMany(InvestigatorServiceLine::class, 'investigation_type_id');
    }
}
