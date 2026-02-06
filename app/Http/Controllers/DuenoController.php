<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;

class DuenoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Dueno::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
        ]);

        $dueno = Dueno::create($validated);
        return response()->json($dueno, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dueno = Dueno::find($id);
        if (!$dueno) {
            return response()->json(['message' => 'Dueño no encontrado'], 404);
        }
        return response()->json($dueno);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dueno = Dueno::find($id);
        if (!$dueno) {
            return response()->json(['message' => 'Dueño no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'string',
            'apellido' => 'string',
        ]);

        $dueno->update($validated);
        return response()->json($dueno);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dueno = Dueno::find($id);
        if (!$dueno) {
            return response()->json(['message' => 'Dueño no encontrado'], 404);
        }

        $dueno->delete();
        return response()->json(['message' => 'Dueño eliminado correctamente']);
    }
}
