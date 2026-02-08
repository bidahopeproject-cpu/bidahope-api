<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organ;
use Illuminate\Http\Request;

class OrganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Organ::orderBy('id')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:organs,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $organ = Organ::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'message' => 'Organ created successfully',
            'data' => $organ
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organ = Organ::findOrFail($id);

        return response()->json($organ);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organ = Organ::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:organs,name,' . $organ->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $organ->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? $organ->description,
            'is_active' => $validated['is_active'] ?? $organ->is_active,
        ]);

        return response()->json([
            'message' => 'Organ updated successfully',
            'data' => $organ
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organ = Organ::findOrFail($id);
        $organ->delete();

        return response()->json([
            'message' => 'Organ deleted successfully'
        ]);
    }
}