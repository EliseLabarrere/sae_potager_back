<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    // KEYWORD
    public function keywords(){
        return $this->belongsToMany(Keyword::class);
    }

    // PLANT
    public function plants(){
        return $this->belongsToMany(Plant::class);
    }
}
