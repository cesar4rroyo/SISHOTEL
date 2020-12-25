<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobante';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipodocumento',
        'numero',
        'fecha',
        'subtotal',
        'igv',
        'total',
        'comentario',
        'movimiento_id',
    ];
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
    public function detalleComprobante()
    {
        return $this->hasMany(DetalleComprobante::class, 'comprobante_id');
    }
}
