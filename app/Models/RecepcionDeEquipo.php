<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Caso;

class RecepcionDeEquipo extends Model
{
    use HasFactory;

    protected $table = 'recepcion_de_equipo';

    protected $fillable = [
        'id_caso',
        'id_equipo',
        'id_usuario_recepcion',
        'id_usuario_tecnico_asignado',
        'tipo_atencion',
        'falla_tecnica',
        'pago',
    ];

    /**
     * Relación con el caso.
     */
    public function caso()
    {
        return $this->belongsTo(Caso::class, 'id_caso');
    }

    /**
     * Relación con el equipo.
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    /**
     * Relación con el usuario que recibe.
     */
    public function usuarioRecepcion()
    {
        return $this->belongsTo(User::class, 'id_usuario_recepcion');
    }

    /**
     * Relación con el técnico asignado.
     */
    public function tecnicoAsignado()
    {
        return $this->belongsTo(User::class, 'id_usuario_tecnico_asignado');
    }
}
