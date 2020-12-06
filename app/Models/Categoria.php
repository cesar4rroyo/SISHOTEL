<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function producto()
    {
        return $this->hasMany(Producto::class);
    }
}
