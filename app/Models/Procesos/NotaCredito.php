<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class NotaCredito extends Model
{
    use SoftDeletes;
	protected $table = 'notacredito';
	protected $dates = ['deleted_at'];

    public function persona()
	{
		return $this->belongsTo('App\Person', 'persona_id');
	}
    public function caja()
	{
		return $this->belongsTo('App\Caja', 'caja_id');
	}
    public function motivo()
	{
		return $this->belongsTo('App\Motivonotacredito', 'motivo_id');
	}
    public function movimiento()
	{
		return $this->belongsTo('App\Movimiento', 'movimiento_id');
	}

    public function concepto()
	{
		return $this->belongsTo('App\Concepto', 'concepto_id');
	}

}
