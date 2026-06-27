<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConservationStatusCriteria extends Model
{
    use HasFactory;

    protected $table = 'conservation_status_criteria';

    protected $fillable = [
        'conservation_status_id',
        'bocc_criteria_id',
    ];

    // Define relationships
    public function conservationStatus()
    {
        return $this->belongsTo(ConservationStatus::class);
    }

    public function boccCriteria()
    {
        return $this->belongsTo(BoccCriteriaDefinition::class);
    }
}
