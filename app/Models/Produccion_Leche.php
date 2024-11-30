<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion_Leche extends Model
{
    use HasFactory;
    protected $table = 'produccion__leches';

    protected $fillable = [
        'productor_id',
        'cantidad_animales',
        'cantidad_litros',
        'fecha_produccion',
        'tipo_ordeño',
    ];
}
