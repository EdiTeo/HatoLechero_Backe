<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaca extends Model
{
    use HasFactory;

    // Indicar que la clave primaria no se llama 'id' sino 'vaca_id'
    protected $primaryKey = 'vaca_id'; 

    // Los campos que se pueden llenar mediante asignación masiva
    protected $fillable = [
        'productor_id',
        'nombre',
        'etapa_de_crecimiento',
        'estado_reproductivo',
        'raza',
        'fecha_nacimiento',
        'estado',
    ];

    // Si la clave primaria no es un entero auto incrementable
    public $incrementing = true;

    // Si la clave primaria no es de tipo entero (en caso de que uses otro tipo)
    // protected $keyType = 'string';
}
