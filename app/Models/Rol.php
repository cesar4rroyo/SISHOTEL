<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{

    protected $table = 'rol';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->belongsToMany(Persona::class, 'rolpersona');
    }
}
