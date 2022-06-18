<?php

namespace App\Models\Procesos;

use App\Librerias\Libreria;
use App\Models\Persona;
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
        'persona_id'
    ];
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function detalleComprobante()
    {
        return $this->hasMany(DetalleComprobante::class, 'comprobante_id');
    }

    public static function generarNumero($tipo)
    {
        $data = Comprobante::where('tipodocumento', $tipo)->latest('id')->first();
        if(!$data){
            $numero = Comprobante::GenerarNumeroSiguiente(1,$tipo, true);
        }else{
            $numero = Comprobante::GenerarNumeroSiguiente($data->numero, $tipo);
        }
        return $numero;
    }

    static function GenerarPrefijo($tipo){
        $prefix = "";
        switch ($tipo) {
            case 'Ticket':
                $prefix = "T";
                break;
            case 'Factura':
                $prefix = "F";
                break;
            case 'Boleta':
                $prefix = "B";
                break;
            default:
                $prefix = "T";
                break;
        }
        $prefix = $prefix . env('SERIE_FACTURACION') . '-';
        return $prefix;
    }

    static function GenerarNumeroSiguiente($numero, $tipo, $nuevo = false){
        if(!$nuevo){
            $numero = substr($numero, -8) + 1;
        }
        return Comprobante::GenerarPrefijo($tipo) . Libreria::zero_fill($numero,8);
    }
}
