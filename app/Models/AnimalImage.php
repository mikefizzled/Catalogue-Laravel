<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
