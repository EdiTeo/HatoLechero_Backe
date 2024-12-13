<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD

class ProduccionLecheController extends Controller
{
    //
=======
use App\Models\Produccion_Leche;

class ProduccionLecheController extends Controller
{
    public function index(){
        return Produccion_Leche::all();
    }
>>>>>>> 8e067eff3492b4990e7506d24cf9716d21790751
}
