<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use Illuminate\Http\Request;

class CampañaController extends Controller
{
    public function index()
    {
        $campañas = Campaña::paginate(10);
        return view('admin.campaña.index', compact('campañas'));
    }


    public function create()
    {
        return view('admin.campaña.create');
    }


    public function store(Request $request, Campaña $Campaña)
    {
        try {
            $Campaña->my_store($request);
            return redirect()->route('campañas.index')->with('success', 'Campaña credada con éxito');
        } catch (\Exception $th) {
            return redirect()->route('campañas.index')->with('error', 'Ocurrió un error al crear la campaña'.$th->getMessage());
        }
    }

    public function show(Campaña $Campaña)
    {
        return view('admin.campaña.show', compact('Campaña'));
    }


    public function edit(Campaña $campaña)
    {
        return view('admin.campaña.edit', compact('campaña'));
    }

    public function update(Request $request, Campaña $Campaña)
    {
        try {
            $Campaña->my_update($request);
            return redirect()->route('campañas.index')->with('success', 'Campaña modificada');
        } catch (\Exception $th) {
            return redirect()->route('campañas.index')->with('error', 'Ocurrió un error al actualizar la campaña');
        }
    }


    public function destroy(Campaña $Campaña)
    {
        try {
            $Campaña->delete();
            return redirect()->route('campañas.index')->with('success', 'Campaña eliminada');
        } catch (\Exception $th) {
            return redirect()->route('campañas.index')->with('error', 'Ocurrió un error al eliminar la campaña');
        }
    }
}
