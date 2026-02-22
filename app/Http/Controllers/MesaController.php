<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Mesa;
use App\Models\User;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::whereHas('users', function ($query) {
            $query->where('parent_id', auth()->id());
        })->paginate(15);

        return view('admin.mesa.index', compact('mesas'));
    }

    public function create()
    {
        $childrens = User::whereNotNull('parent_id')->get();
        return view('admin.mesa.create', compact('childrens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'puesto_votacion' => 'required|string|max:255',
            'mesa' => 'required|string|max:255',
            'zona' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $mesa = Mesa::create($request->except('user_id'));

        if ($request->filled('user_id')) {
            User::where('id', $request->user_id)
                ->update(['mesa_id' => $mesa->id]);
        }

        return redirect()->route('mesas.index')
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
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'puesto_votacion' => 'required|string|max:255',
            'mesa' => 'required|string|max:255',
            'zona' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $mesa->update($request->all());

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa eliminada correctamente.');
    }

    public function buscarUsuario(Request $request)
    {
        $cedula = $request->get('cedula');

        $user = User::where('cedula', $cedula)
            ->whereNull('mesa_id') // solo usuarios sin mesa asignada
            ->select('id', 'cedula', 'name', 'surname', 'email')
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado o ya tiene mesa asignada'], 404);
        }

        return response()->json($user);
    }
}