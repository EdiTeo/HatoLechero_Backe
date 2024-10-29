<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaca extends Model
{
    use HasFactory;

    protected $primaryKey = 'vaca_id';

    public function productor()
    {
        return $this->belongsTo(Productor::class, 'productor_id');
    }
    public function produccionLeche()
    {
        return $this->hasMany(ProduccionLeche::class, 'vaca_id');
    }
}
