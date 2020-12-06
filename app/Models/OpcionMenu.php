<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionMenu extends Model
{
    protected $table = 'opcionmenu';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'icono', 'orden', 'link', 'grupomenu_id'];

    public function grupomenu()
    {
        return $this->belongsTo(GrupoMenu::class, 'grupomenu_id');
    }
}
