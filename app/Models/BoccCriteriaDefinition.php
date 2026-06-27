<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoccCriteriaDefinition extends Model
{
    public function conservationStatuses()
    {
        return $this->hasMany(ConservationStatusCriteria::class);
    }
}
