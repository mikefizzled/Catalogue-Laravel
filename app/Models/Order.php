<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Order extends Model
{
    use Sluggable;

    protected $fillable = ['order_name', 'slug'];
    

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function getRouteKeyName() 
    { 
        return 'slug'; 
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'order_name',
                'onUpdate' => true,
            ]
        ];
    }
}
