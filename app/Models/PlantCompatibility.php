<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantCompatibility extends Model
{
    use HasFactory;

    protected $with = ['plant','other_plant'];

    //PLANT
    public function plant()
    {
        return $this->belongsToMany(Plant::class, 'plant_id');
    }

    //OTHER PLANT
    public function other_plant()
    {
        return $this->belongsToMany(Plant::class, 'other_plant_id');
    }

}
