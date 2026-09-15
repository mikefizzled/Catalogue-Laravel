<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    // Allow the metadato be cast as an array rather the string its effectively stored as
    protected $casts = [
        'metadata' => 'array', ];


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
        if ($this->media_type === 'video') {
            return asset('images/placeholder-video.svg');
        }

        if (! $this->thumbnail_url) {
            return asset('images/placeholder-image.svg');
        }

        return Storage::disk('s3')->url(
            'media/' . $this->thumbnail_url
        );
    }

    public function getMediaUrlAttribute(): ?string
    {
        if (! $this->attributes['media_url']) {
            return null;
        }

        return Storage::disk('s3')->url(
            'media/' . $this->attributes['media_url']
        );
    }

}
