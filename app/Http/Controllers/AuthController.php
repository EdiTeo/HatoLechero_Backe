<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productores; // Asegúrate de usar el modelo Productores
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

        $productor = Productores::create([ // Usando Productores correctamente
            'nombre' => $request->nombre,
            'email' => $request->email,
            'celular' => $request->celular,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Productor registrado exitosamente'], 201);
    }

    public function login(Request $request)
{
    $validated = $request->validate([
        'celular' => 'required|string',
        'password' => 'required|string',
    ]);

    // Buscar al productor con el celular proporcionado
    $productor = Productores::where('celular', $validated['celular'])->first();

    // Verificar si el productor existe y la contraseña es correcta
    if ($productor && Hash::check($validated['password'], $productor->password)) {
        // Login exitoso
        Auth::login($productor);

        // Devolver el id del productor junto con el mensaje de éxito
        return response()->json([
            'message' => 'Login successful',
            'productor_id' => $productor->productor_id, // Devuelve el id del productor
        ], 200);
    } else {
        // Si el celular o la contraseña son incorrectos
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
}
