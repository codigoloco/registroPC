<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoCliente extends Model
{
    use HasFactory;

    protected $table = 'contactos_clientes';

    protected $fillable = [
        'id_cliente',
        'telefono_cliente',
        'correo_cliente',
    ];

    /**
     * Obtener el cliente al que pertenece el contacto.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
