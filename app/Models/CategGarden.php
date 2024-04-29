<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategGarden extends Model
{
    use HasFactory;

    protected $with = ['plants'];

    public function plants(){
        return $this->belongsToMany(Plant::class);
    }
}
