<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeEquipo extends Model
{
    protected $table = 'tipo_de_equipo';
    protected $fillable = ['nombre'];
    public $incrementing = true;
}
