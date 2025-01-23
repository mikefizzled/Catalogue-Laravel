<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['family_name', 'common_name', 'order_id'];

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('family_name')    
            ->saveSlugsTo('slug');
    }

    /**
     * Scope a query to order families by name.
     */
    public function scopeOrderedByName($query)
    {
        return $query->orderBy('family_name', 'asc');
    }
}
