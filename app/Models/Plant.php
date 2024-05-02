<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\EngineManager;

class Plant extends Model
{
    use Searchable, HasFactory;

    //protected $with = ['categ_plant','categ_garden','user'];

    //CATEG PLANT
    public function categ_plant(){
        return $this->belongsTo(CategPlant::class, 'categ_plant_id', 'id');
    }

    //CATEG GARDEN
    public function Categ_garden(){
        return $this->belongsToMany(CategGarden::class);
    }

    // TIP
    public function tips(){
        return $this->belongsToMany(Tip::class);
    }

    //USER
    public function user(){
        return $this->belongsToMany(User::class);
    }

    //COMPATIBILITIES
    public function compatibilities()
    {
        return $this->hasMany(PlantCompatibility::class, 'plant_id', 'id');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return [
            'plant' => $array['name'],
        ];
    }
}
