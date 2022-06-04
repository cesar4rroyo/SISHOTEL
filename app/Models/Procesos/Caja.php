<?php

namespace App\Models\Procesos;

use App\Librerias\Libreria;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Seguridad\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use SoftDeletes;
    protected $table = 'caja';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at', 'fecha', 'created_at', 'updated_at'];

    protected $fillable = [
        'fecha',
        'tipo',
        'numero',
        'total',
        'comentario',
        'situacion',
        'concepto_id',
        'persona_id',
        'movimiento_id',
        'usuario_id',
        'montovisa',
        'montomastercard',
        'montoamex',
        'montoyape',
        'montoplin',
        'montodeposito',
        'montoefectivo',
        'modalidadpago',
        'nrooperacion',
    ];
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function detallecaja()
    {
        return $this->hasMany(DetalleCaja::class, 'caja_id');
    }

    public function idUltimaApertura()
    {
        $caja = $this->where('concepto_id', 1)->latest('created_at')->first();
        return $caja->id;
    }

    public function cajaAbierta()
    {
        $caja = $this->latest('created_at')->first();
        if ($caja->concepto_id == 2) {
            return false;
        } else { //CAJA ABIERTA
            return true;
        }
    }
    public function scopelistar($query, $concepto_id, $idApertura)
    {
        return $query
            ->where(function ($subquery) use ($concepto_id) {
                if (!is_null($concepto_id) && strlen($concepto_id) > 0) {
                    $subquery->where('concepto_id', $concepto_id);
                }
            })
            ->where(function ($subquery) use ($idApertura) {
                if (!is_null($idApertura) && strlen($idApertura) > 0) {
                    $subquery->where('id', '>=', $idApertura);
                }
            })
            ->orderBy('created_at', 'DESC');
    }

    public function generarNumero()
    {
        $caja = $this->latest('created_at')->first();
        $nro = isset($caja) ? $caja->numero : 0;
        return Libreria::zero_fill($nro + 1, 6);
    }

    public function generarTotalIngresos()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->sum('total');
    }

    public function generarTotalEgresos()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Egreso')->where('id', '>=', $idApertura)->where('concepto_id', '!=', '2')->sum('total');
    }

    public function generarTotalEfectivo()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montoefectivo')->sum('montoefectivo');
    }

    public function generarTotalVisa()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montovisa')->sum('montovisa');
    }

    public function generarTotalMastercard()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montomastercard')->sum('montomastercard');
    }

    public function generarTotalAmex()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montoamex')->sum('montoamex');
    }

    public function generarTotalYape()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montoyape')->sum('montoyape');
    }

    public function generarTotalPlin()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montoplin')->sum('montoplin');
    }

    public function generarTotalDeposito()
    {
        $idApertura = $this->idUltimaApertura();
        return $this->where('tipo', 'Ingreso')->where('id', '>=', $idApertura)->whereNotNull('montodeposito')->sum('montodeposito');
    }

    public function generarTotalTarjetas()
    {
        return $this->generarTotalAmex() + $this->generarTotalMastercard() + $this->generarTotalVisa();
    }

    public function generarTotalTransferencias()
    {
        return $this->generarTotalPlin() + $this->generarTotalPlin();
    }

    public function generarTotalCuadreCaja()
    {
        return $this->generarTotalIngresos() - $this->generarTotalEgresos();
    }
}
