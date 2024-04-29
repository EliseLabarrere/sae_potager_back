<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $with = ['categ_plant'];

    //CATEG PLANT
    public function categ_plant(){
        return $this->belongsTo(CategPlant::class, 'categ_plant_id', 'id');
    }
}
