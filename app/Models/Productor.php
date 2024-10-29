<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Productor extends Model
{
    use HasFactory;

    protected $primaryKey = 'productor_id';

    public function vacas()
    {
        return $this->hasMany(Vaca::class, 'productor_id');
    }
}
