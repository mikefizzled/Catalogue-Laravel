<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Order extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['order_name', 'slug'];

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Configure the SlugOptions for this model.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('order_name')
            ->saveSlugsTo('slug');
    }

    // Functions for admin cfg
    public function getTitleAttribute(): string
    {
        return $this->order_name;
    }
}
