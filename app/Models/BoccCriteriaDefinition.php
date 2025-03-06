<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConservationStatusCriteria;

class BoccCriteriaDefinition extends Model
{
    public function conservationStatuses()
    {
        return $this->hasMany(ConservationStatusCriteria::class);
    }

}
