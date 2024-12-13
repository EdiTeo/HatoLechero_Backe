<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialMedico;

class HistorialMedicoController extends Controller
{
    public function index(){
        return HistorialMedico::all();
    }
}
