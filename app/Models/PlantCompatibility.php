<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantCompatibility extends Model
{

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }

    // Relation avec la table plants pour l'autre plante
    public function otherPlant()
    {
        return $this->belongsTo(Plant::class, 'other_plant_id', 'id');
    }
}
