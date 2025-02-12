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
    ];

    public static function countMedia($animalId) : int
    {
        $total = Media::where('animal_id', $animalId)->count();
        if($total === 0){
            return 1;
        }
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
}
