<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMenu extends Model
{

    protected $table = 'grupomenu';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'icono', 'orden'];
    public function opcionmenu()
    {
        return $this->hasMany(OpcionMenu::class);
    }
}
