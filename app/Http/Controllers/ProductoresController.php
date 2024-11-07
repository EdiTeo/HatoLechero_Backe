<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productores;

class ProductoresController extends Controller
{
    public function index(){
        return Productores::all();
    }
    //
}
