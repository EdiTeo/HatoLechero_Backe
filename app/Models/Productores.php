<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Productores extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'productores';
    protected $primaryKey = 'productor_id';

    protected $fillable = ['nombre', 'celular', 'email', 'password'];

    protected $hidden = ['password','remember_token',];
}