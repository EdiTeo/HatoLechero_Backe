<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;
    // Si el nombre de la tabla no sigue la convención plural de Laravel
    protected $table = 'historial_medicos';

    // Protección contra asignación masiva
    protected $fillable = [
        'vaca_id',
        'descripcion',
        'tipo',
        'medicamento',
        'notas',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Relación con la tabla vacas
    public function vaca()
    {
        return $this->belongsTo(Vaca::class, 'vaca_id', 'vaca_id');
    }
    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];
    // Conversión de fechas
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];
}
