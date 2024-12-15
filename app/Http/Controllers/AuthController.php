<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use App\Models\Productores;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:productores',
            
            'password' => 'required|string|min:8',
        ]);

        $productor = Productores::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'celular' => $request->celular,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Productor registrado exitosamente'], 201);
    }

    public function login(Request $request)
    {
        
    }
}