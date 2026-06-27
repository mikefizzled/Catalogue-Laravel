<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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

    public static function getForAnimal(int $animalId)
    {
        return self::whereHas('media', function ($query) use ($animalId) {
            $query->where('animal_id', $animalId);
        })->get();

    }

    // Functions for admin cfg
    public function getTitleAttribute(): string
    {
        return $this->name;
    }

    public function getSubtitleAttribute(): string
    {
        return $this->city;
    }

    public function getThumbnailAttribute(): string
    {
        return $this->image;
    }
}
