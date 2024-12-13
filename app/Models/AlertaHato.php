<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertaHato extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'alertas_hato';

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'productor_id',
        'fecha_alerta',
        'tipo_alerta',
        'nota'
    ];

    // Definir la relación con el Productor (suponiendo que tienes una relación con Productores)
    public function productor()
    {
        return $this->belongsTo(Productor::class, 'productor_id');
    }
}
