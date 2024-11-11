<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reproduccion;

class ReproduccionController extends Controller
{
    public function index(){
        return Reproduccion::all();
    }
}
