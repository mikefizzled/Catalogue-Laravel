<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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

    // Functions for admin cfg
    public function getTitleAttribute(): string
    {
        return $this->genus_name;
    }

    public function getSubtitleAttribute(): string
    {
        $orderName = $this->family->order->order_name;
        $familyName = $this->family->family_name;
        $genusName = $this->genus_name;

        return "{$orderName} → {$familyName} → {$genusName}";
    }
}
