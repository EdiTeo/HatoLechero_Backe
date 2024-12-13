<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reproduccion extends Model
{
    use HasFactory;

    // Especificamos que la clave primaria es 'reproduccion_id'
    protected $primaryKey = 'reproduccion_id';

    // Si la clave primaria es autoincrementable (como se espera), esta línea es opcional
    public $incrementing = true;

    // Si la clave primaria es de tipo entero (en este caso, lo es), puedes especificarlo
    protected $keyType = 'int';
    public function vaca()
    {
        return $this->belongsTo(Vaca::class, 'vaca_id', 'vaca_id');
    }
    
    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'vaca_id',
        'fecha_inseminacion',
        'fecha_estimada_parto',
        'fecha_revision',
        'fecha_secado',
        'raza_toro',
        'nota',
    ];
}
