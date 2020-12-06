<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{

    protected $table = 'nacionalidad';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany(Persona::class);
    }
}
