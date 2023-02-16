<?php

namespace App\Models;

use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Procesos\DetalleMovimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicios extends Model
{

    use SoftDeletes;

    protected $table = 'servicios';

    protected $primaryKey = 'id';

    protected $fillable = ['nombre', 'precio'];

    public function detalleComprobante()
    {
        return $this->hasMany(DetalleComprobante::class, 'servicio_id');
    }
    public function detalleCaja()
    {
        return $this->hasMany(DetalleCaja::class, 'servicio_id');
    }
    public function detalleMovimiento()
    {
        return $this->hasMany(DetalleMovimiento::class, 'servicio_id');
    }
}