<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_name', 'slug'];
    
    protected static function boot() {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->title);
        });
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function getRouteKeyName() 
    { 
        return 'slug'; 
    }


}
