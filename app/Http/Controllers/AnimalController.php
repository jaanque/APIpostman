<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Animal::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'tipo' => ['required', Rule::in(['perro', 'gato', 'hámster', 'conejo'])],
            'peso' => 'required|numeric',
            'enfermedad' => 'nullable|string',
            'comentarios' => 'nullable|string',
            'dueno_id' => 'required|exists:duenos,id',
        ]);

        $animal = Animal::create($validated);
        return response()->json($animal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $animal = Animal::find($id);
        if (!$animal) {
            return response()->json(['message' => 'Animal no encontrado'], 404);
        }
        return response()->json($animal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $animal = Animal::find($id);
        if (!$animal) {
            return response()->json(['message' => 'Animal no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'string',
            'tipo' => [Rule::in(['perro', 'gato', 'hámster', 'conejo'])],
            'peso' => 'numeric',
            'enfermedad' => 'nullable|string',
            'comentarios' => 'nullable|string',
            'dueno_id' => 'exists:duenos,id',
        ]);

        $animal->update($validated);
        return response()->json($animal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $animal = Animal::find($id);
        if (!$animal) {
            return response()->json(['message' => 'Animal no encontrado'], 404);
        }

        $animal->delete();
        return response()->json(['message' => 'Animal eliminado correctamente']);
    }
}
