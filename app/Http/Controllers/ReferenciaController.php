<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use App\Models\User;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function index()
    {
        $referencias = auth()->user()->referencias;
        return view('admin.referencia.index', compact('referencias'));
    }

    public function create()
    {
        return view('admin.referencia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'objetivo' => 'nullable|string|max:100',
            'fuente' => 'nullable|string|max:100',
            'medio' => 'nullable|string|max:100',
        ]);
        $nuevareferencia = auth()->user()->referencias()->create($request->all());

        return redirect()->route('referencias.index')
            ->with('show_modal', true)
            ->with('modal_config', [
                'title' => '¡Referencia creada con éxito!',
                'message' => 'Comparte este enlace para registrar nuevos referidos',
                'user_id' => auth()->id(),
                'fuente' => $nuevareferencia->id,
            ]);
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
    $referido = Referencia::find($request->ref_id)->first();

    return view('admin.form.index', [
        'referidor' => $referidor,
        'referido' => $referido,
        'fuente' => $request->fuente,
        'medio' => $request->medio
    ]);
}
}
