<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiezaSoporte extends Model
{
    use HasFactory;

    protected $table = 'pieza_soporte';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
