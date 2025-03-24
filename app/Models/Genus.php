<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genus extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['genus_name', 'family_id'];

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

        /**
     * Configure the SlugOptions for this model.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('genus_name')
            ->saveSlugsTo('slug');
    }
}
