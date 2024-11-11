<?php

namespace App\Models;
<<<<<<< HEAD
=======

>>>>>>> 8e067eff3492b4990e7506d24cf9716d21790751
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaca extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $primaryKey = 'vaca_id';

    public function productor()
    {
        return $this->belongsTo(Productor::class, 'productor_id');
    }
    public function produccionLeche()
    {
        return $this->hasMany(ProduccionLeche::class, 'vaca_id');
    }
=======
    protected $fillable = [
        'productor_id',
        'nombre',
        'etapa_de_crecimiento',
        'estado_reproductivo',
        'raza',
        'fecha_nacimiento',
        'estado',
    ];
>>>>>>> 8e067eff3492b4990e7506d24cf9716d21790751
}
