<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';

    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'descripcion_falla',
        'pieza_sugerida',
        'forma_de_atencion',
        'estatus',
    ];

    /**
     * Obtener el cliente asociado al caso.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Obtener el técnico (usuario) asociado al caso.
     */
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Obtener la documentación (piezas/servicios) asociada al caso.
     */
    public function documentacion()
    {
        return $this->hasMany(DocumentacionCaso::class, 'id_caso');
    }
}
