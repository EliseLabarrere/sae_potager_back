<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantUser extends Model
{
    use HasFactory;

    protected $table = 'plant_user';

    protected $fillable = [
        'nickname',
        'last_watering',
    ];

    // User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Plant
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
