<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaDeEquipo extends Model
{
    use HasFactory;

    protected $table = 'entrega_de_equipo';

    protected $fillable = [
        'id_caso',
        'id_equipo',
        'id_usuario_entrega',
        'deposito',
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
     * Relación con el usuario que entrega.
     */
    public function usuarioEntrega()
    {
        return $this->belongsTo(User::class, 'id_usuario_entrega');
    }
}
