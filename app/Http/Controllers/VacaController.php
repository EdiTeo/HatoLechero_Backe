<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaca;

class VacaController extends Controller
{
    public function index(){
        return Vaca::all();
    }
}
