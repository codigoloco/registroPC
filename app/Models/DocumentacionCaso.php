<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentacionCaso extends Model
{
    use HasFactory;

    protected $table = 'documentacion_de_caso';

    protected $fillable = [
        'id_caso',
        'id_pieza_soporte',
        'cantidad',
        'observacion',
    ];

    /**
     * Obtener el caso al que pertenece la documentación.
     */
    public function caso()
    {
        return $this->belongsTo(Caso::class, 'id_caso');
    }

    /**
     * Obtener la pieza o servicio registrado.
     */
    public function piezaSoporte()
    {
        // Nota: Asumiendo que existe un modelo PiezaSoporte o similar si se desea relación Eloquent.
        return $this->belongsTo(PiezaSoporte::class, 'id_pieza_soporte');
    }
}
