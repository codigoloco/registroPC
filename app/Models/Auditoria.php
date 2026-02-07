<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditoria';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'id_usuario',
        'id_caso',
        'estado_inicial',
        'estado_final',
        'ip',
        'sentencia',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'estado_inicial' => 'array',
        'estado_final' => 'array',
    ];

    /**
     * Indica si el modelo debe tener timestamps.
     * Eloquent lo maneja automaticamente si el campo created_at y updated_at existen.
     */
    public $timestamps = true;

    /**
     * Relación con el usuario que realizó la acción.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con el caso auditado.
     */
    public function caso()
    {
        return $this->belongsTo(Caso::class, 'id_caso');
    }
}
