<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $table = 'tarjeta';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo',
        'numero',
        'titular',
        'fechavencimiento',
    ];

    public function movimiento()
    {
        return $this->hasMany(Movimiento::class);
    }
}
