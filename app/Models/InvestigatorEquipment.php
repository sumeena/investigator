<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestigatorEquipment extends Model
{
    use HasFactory;
    
    protected $table = 'investigator_equipments';
    protected $guarded = ['id'];

    /**
     * Get the investigator that owns the equipment.
     * @return BelongsTo
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
