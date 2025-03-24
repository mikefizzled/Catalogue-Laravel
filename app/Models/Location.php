<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, HasSlug;
    
    protected $fillable = ['name', 'city', 'latitude', 'longitude', 'area_caption', 'image'];

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    
    public static function getForAnimal($animalId)
    {
        return self::whereHas('media', function ($query) use ($animalId) {
            $query->where('animal_id', $animalId);
        })->get();

    }
}
