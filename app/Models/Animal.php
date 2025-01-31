<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['genus_id', 'common_name', 'scientific_name', 'thumbnail_url'];

    public function genus()
    {
        return $this->belongsTo(Genus::class);
    }

    public function images()
    {
        return $this->hasMany(Media::class);
    }

    public function getRouteKeyName() : string
    { 
        return 'slug'; 
    }

    public function conservationStatuses()
    {
        return $this->hasMany(ConservationStatus::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('common_name')    
            ->saveSlugsTo('slug');
    }
}
