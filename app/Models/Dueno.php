<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $fillable = ['nombre', 'apellido'];

    public function animales()
    {
        return $this->hasMany(Animal::class);
    }
}
