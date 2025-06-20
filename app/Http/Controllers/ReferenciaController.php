<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use App\Models\Referencia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ActividadService;
use App\Constants\ActividadPlantillas;

class ReferenciaController extends Controller
{
    public function index()
    {
        $referencias = Referencia::all();
        return view('admin.referencia.index', compact('referencias'));
    }

    public function create()
    {
        $campañas = Campaña::where('estado', 'activo')
            ->where('tipo', 'publica')
            ->get();
        if ($campañas->isEmpty()) {
            return back()->with('error', 'No hay campañas activas para crear una referencia');
        }

        return view('admin.referencia.create', compact('campañas'));
    }

    public function edit(Referencia $referencia)
    {
        $campañas = Campaña::get();
        return view('admin.referencia.edit', compact('referencia', 'campañas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'objetivo' => 'nullable|string|max:100',
            'fuente' => 'nullable|string|max:100',
            'medio' => 'nullable|string|max:100',
        ]);
        $nuevareferencia = auth()->user()->referencias()->create($request->all());

        if (!$nuevareferencia) {
            return back()->with('error', 'Ocurrió un error al crear la referencia');
        }
        if ($nuevareferencia) {
            $this->notified(auth()->id());
        }
        return redirect()->route('referencias.index')
            ->with('show_modal', true)
            ->with('modal_config', [
                'title' => '¡Referencia creada con éxito!',
                'message' => 'Comparte este enlace para registrar nuevos referidos',
                'usr' => auth()->id(),
                'fuente' => $request->fuente,
                'medio' => $request->medio,
                'ref_id' => $nuevareferencia->id,
            ]);
    }

    public function update(Referencia $referencia, Request $request)
    {

        $request->validate([
            'campaña_id' => 'required',
            'objetivo' => 'nullable|string|max:100',
            'fuente' => 'nullable|string|max:100',
            'medio' => 'nullable|string|max:100',
        ]);


        try {

            $referencia->update($request->all());
            return back()->with('success', 'Referencia actualizada');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrió un error al actualizar la referencia ' . $th->getMessage());
        }
    }




    public function destroy(Referencia $referencia)
    {
        try {
            $referencia->delete();
            return back()->with('success', 'Campaña eliminada');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrió un error al eliminar la referencia');
        }
    }

    public function mostrarFormularioRegistro(Request $request)
    {

        $request->validate([
            'usr' => 'nullable|exists:users,id',
            'fuente' => 'nullable|string',
            'medio' => 'nullable|string',
            'ref_id' => 'nullable',
        ]);

        $referidor = User::find($request->usr);
        $referido = Referencia::find($request->ref_id);



        if (!$referidor || !$referido) {
            return redirect('login')->with('error', 'El referidor o la referencia no existen');
        }
        if (!$referido->campaña->fecha_fin || $referido->campaña->fecha_fin < now()) {
            return redirect('login')->with('error', 'La campaña asociada a la referencia ha finalizado');
        }
        if (!$referido->campaña) {
            return redirect('login')->with('error', 'La referencia no tiene una campaña asociada');
        }
        if ($referido->campaña->estado !== 'activo') {
            return redirect('login')->with('error', 'La campaña asociada a la referencia no está activa');
        }
        if ($referido->campaña->tipo !== 'publica' && $referido->user->id !== auth()->id()) {
            return back()->with('error', 'La campaña asociada a la referencia no es pública');
        }


        return view('admin.form.index', [
            'referidor' => $referidor,
            'referido' => $referido,
            'fuente' => $request->fuente,
            'medio' => $request->medio,
            'referencia_id' => $request->ref_id,
        ]);
    }


    public function notified($id)
    {
        ActividadService::registrar(
            ActividadPlantillas::NUEVA_REFERENCIA
        );
    }

}
