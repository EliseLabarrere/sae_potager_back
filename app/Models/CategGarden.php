<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategGarden extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
