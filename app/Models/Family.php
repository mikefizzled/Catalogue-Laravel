<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function genera()
    {
        return $this->hasMany(Genus::class);
    }

    public function getRouteKeyName() 
    { 
        return 'slug'; 
    }
}
