<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produccion_Leche;

class ProduccionLecheController extends Controller
{
    public function index(){
        return Produccion_Leche::all();
    }
}
