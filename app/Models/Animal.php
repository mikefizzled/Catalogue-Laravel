<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['genus_id', 'common_name', 'scientific_name', 'thumbnail_url', 'ebird_species_code'];

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

    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public static function getSlug($animalId)
    {
        return self::where('id', $animalId)->value('slug') ?? 'Unknown';
    }

    // Functions for admin cfg
    public function getTitleAttribute(): string
    {
        return $this->common_name;
    }

    public function getSubtitleAttribute(): string
    {
        return $this->scientific_name;
    }

    public function getThumbnailAttribute(): string
    {
        return $this->thumbnail_url;
    }

    public function bocCriteriaCodes(int $listId): string
    {
        $cs = $this->conservationStatuses
            ->firstWhere('conservation_list_id', $listId);

        if (! $cs) {
            return '';
        }

        return $cs->criteria
            ->map(fn($c) => $c->boccCriteria->code)
            ->implode('; ');
    }
    public function getStatusMapAttribute(): array
    {
        // Assumes you’ve eager-loaded conservationStatuses
        return $this->conservationStatuses
                    ->pluck('status', 'conservation_list_id')
                    ->toArray();
    }
}
