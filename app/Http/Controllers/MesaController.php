<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::paginate(15);
        return view('admin.mesa.index', compact('mesas'));
    }

    public function create()
    {
        return view('admin.mesa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'departamento'   => 'required|string|max:255',
            'municipio'      => 'required|string|max:255',
            'puesto_votacion'=> 'required|string|max:255',
            'mesa'           => 'required|string|max:255',
            'zona'           => 'nullable|string|max:255',
            'direccion'      => 'nullable|string|max:255',
        ]);

        Mesa::create($request->all());

        return redirect()->route('admin.mesa.index')
                         ->with('success', 'Mesa creada correctamente.');
    }

    public function show(Mesa $mesa)
    {
        return view('admin.mesa.show', compact('mesa'));
    }

    public function edit(Mesa $mesa)
    {
        return view('admin.mesa.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'departamento'   => 'required|string|max:255',
            'municipio'      => 'required|string|max:255',
            'puesto_votacion'=> 'required|string|max:255',
            'mesa'           => 'required|string|max:255',
            'zona'           => 'nullable|string|max:255',
            'direccion'      => 'nullable|string|max:255',
        ]);

        $mesa->update($request->all());

        return redirect()->route('admin.mesa.index')
                         ->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return redirect()->route('admin.mesa.index')
                         ->with('success', 'Mesa eliminada correctamente.');
    }
}