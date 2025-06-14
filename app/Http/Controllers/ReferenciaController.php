<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
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
            'campaña' => 'nullable|string|max:100',
            'objetivo' => 'nullable|string|max:100',
            'fuente' => 'nullable|string|max:100',
            'medio' => 'nullable|string|max:100',
        ]);

        auth()->user()->referencias()->create($request->all());

        return redirect()->route('referencias.index')->with('message', 'Referencia creada con éxito');
    }
}
