<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'hash'
    ];

    public static function nextMediaNumber($animalId, $mediaType) :int
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
    
    public static function defaultAudioThumbnail()
    {
        return asset('images/default-music-thumbnail.svg');
    }


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
     *  Scope: Filter media by type (image, audio, video)
     *  https://laravel.com/docs/12.x/eloquent#dynamic-scopes
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('media_type', $type)->orderBy('rating', 'desc');
    }

    /**
     *  Get all images for a given animal
     */
    public static function getImagesForAnimal($animalId)
    {
        return self::where('animal_id', $animalId)->ofType('image')->get();
    }

    /**
     *  Get all audio clips for a given animal
     */
    public static function getAudioForAnimal($animalId)
    {
        return self::where('animal_id', $animalId)->ofType('audio')->get();
    }
}
