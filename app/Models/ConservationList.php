<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationList extends Model
{
    public function conservationStatuses()
    {
        return $this->hasMany(ConservationStatus::class);
    }
}
