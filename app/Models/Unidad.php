<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidad';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function producto()
    {
        return $this->hasMany(Producto::class);
    }
}
