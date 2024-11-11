<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaca extends Model
{
    use HasFactory;
    protected $fillable = [
        'productor_id',
        'nombre',
        'etapa_de_crecimiento',
        'estado_reproductivo',
        'raza',
        'fecha_nacimiento',
        'estado',
    ];
}
