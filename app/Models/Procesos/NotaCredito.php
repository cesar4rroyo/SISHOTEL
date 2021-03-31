<?php

namespace App\Models\Procesos;

use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class NotaCredito extends Model
{
    use SoftDeletes;
	protected $table = 'notacredito';
	protected $dates = ['deleted_at'];
	protected $fillable = [
        'fecha',
        'numero',
        'motivo',
        'total',
        'igv',
        'subtotal',
        'observacion',
        'situacion',
        'concepto_id',
        'persona_id',
        'comprobante_id',
        'usuario_id',
    ];

    public function persona()
	{
		return $this->belongsTo(Persona::class, 'persona_id');
	}
      
    public function comprobante()
	{
		return $this->belongsTo(Comprobante::class, 'comprobante_id');
	}

    public function concepto()
	{
		return $this->belongsTo(Concepto::class, 'concepto_id');
	}
	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuario_id');
	}

	public function detallenotacredito()
    {
        return $this->hasMany(Detallenotacredito::class, 'notacredito_id');
    }

	public function scopelistarNota($query, $fecinicio, $fecfin, $numero, $proveedor)
	{
		return $query->join('persona', 'persona.id', '=', 'notacredito.persona_id')
			//->join('usuario', 'usuario.id', '=', 'notacredito.usuario_id')
			// ->where('tipomovimiento_id', '=', 1)			
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('fecha', '>=', $fecinicio);
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fecha', '<=', $fecfin);
				}
			})
			/* ->where(function ($subquery) use ($tipodocumento) {
				if (!is_null($tipodocumento) && strlen($tipodocumento) > 0) {
					$subquery->where('tipodocumento_id', '=', $tipodocumento);
				}
			}) */
			->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', "%" . $numero . "%");
				}
			})
			->where(function ($subquery) use ($proveedor) {
				if (!is_null($proveedor) && strlen($proveedor) > 0) {
					$subquery->where(DB::raw('concat(persona.apellidos,\' \',persona.nombres)'), 'LIKE', "%" . $proveedor . "%");
				}
			})
			->select('notacredito.*', DB::raw('concat(persona.apellidos,\' \',persona.nombres) as cliente'))
			->orderBy('fecha', 'ASC');
	}

}
