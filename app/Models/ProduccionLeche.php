<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vaca;
class ProduccionLeche extends Model
{
    use HasFactory;

    protected $primaryKey = 'produccion_id';

    public function vaca()
    {
        return $this->belongsTo(Vaca::class, 'vaca_id');
    }
}