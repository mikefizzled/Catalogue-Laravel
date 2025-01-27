<?php

namespace App\Models;

use App\Models\Animal;
use App\Models\ConservationList;
use Illuminate\Database\Eloquent\Model;

class ConservationStatus extends Model
{
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function conservationList()
    {
        return $this->belongsTo(ConservationList::class);
    }
}
