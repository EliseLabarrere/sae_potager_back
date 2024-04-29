<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $with = ['categ_plant','categ_garden'];

    //CATEG PLANT
    public function categ_plant(){
        return $this->belongsTo(CategPlant::class, 'categ_plant_id', 'id');
    }

    //CATEG GARDEN
    public function Categ_garden(){
        return $this->belongsToMany(CategGarden::class);
    }
}
