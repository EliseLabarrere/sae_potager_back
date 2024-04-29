<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname',
        'last_watering',
    ];
}
