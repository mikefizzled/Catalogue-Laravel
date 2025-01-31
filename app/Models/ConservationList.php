<?php

namespace App\Models;

use App\Models\ConservationStatus;
use Illuminate\Database\Eloquent\Model;

class ConservationList extends Model
{
    public function conservationStatuses()
    {
        return $this->hasMany(ConservationStatus::class);
    }
}
