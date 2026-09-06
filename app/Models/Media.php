<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'animal_id',
        'location_id',
        'media_url',
        'thumbnail_url',
        'media_type',
        'rating',
        'date_taken',
        'caption',
        'gender',
        'age',
        'metadata',
        'hash',
    ];

    public static function nextMediaNumber($animalId, $mediaType): int
    {
        $total = Media::where('animal_id', $animalId)
            ->where('media_type', $mediaType)
            ->count();
        $total++;

        return $total;
    }

    const GENDERS = [
        ['id' => 'Male', 'label' => 'Male'],
        ['id' => 'Female', 'label' => 'Female'],
        ['id' => 'Unknown', 'label' => 'Unknown'],
    ];

    const AGES = [
        ['id' => 'Juvenile', 'label' => 'Juvenile'],
        ['id' => 'Adult', 'label' => 'Adult'],
        ['id' => 'Unknown', 'label' => 'Unknown'],
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     *  Get all images and videos for a given animal
     */
    public static function getVisualMediaForAnimal($animalId)
    {
        return self::where('animal_id', $animalId)
            ->whereIn('media_type', ['image', 'video'])
            ->orderBy('rating', 'desc')
            ->get();
    }

    // Functions for admin cfg
    public function getTitleAttribute(): string
    {
        return $this->animal->common_name;
    }

    public function getSubtitleAttribute(): string
    {
        $location = $this->location->name;
        $date = Carbon::parse($this->date_taken)->format('F j, Y');

        return "{$location} – {$date}";
    }

    public function getThumbnailAttribute(): string
    {
        return $this->thumbnail_url;
    }
}
