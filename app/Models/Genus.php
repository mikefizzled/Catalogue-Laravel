<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genus extends Model
{
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
    
    public function getRouteKeyName() 
    { 
        return 'slug'; 
    }
}
