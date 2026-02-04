<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_tipo',
        'id_modelo',
        'serial_equipo'
    ];

    /**
     * Obtiene el tipo de equipo asociado.
     */
    public function tipo()
    {
        return $this->belongsTo(TipoDeEquipo::class, 'id_tipo');
    }

    /**
     * Obtiene el modelo asociado.
     */
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'id_modelo');
    }
}
