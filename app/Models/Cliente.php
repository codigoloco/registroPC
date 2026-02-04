<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    // Desactivar incremento ya que usamos el ID proporcionado (Cedula/RIF)
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'direccion',
        'tipo_cliente',
    ];

    /**
     * Obtener los contactos del cliente.
     */
    public function contactos()
    {
        return $this->hasMany(ContactoCliente::class, 'id_cliente');
    }
}
