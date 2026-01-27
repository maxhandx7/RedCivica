<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function index(Request $request)
    {
        $query = Answers::with('user')->latest();
        
        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('numero_documento', 'like', "%{$search}%");
            });
        }
        
        // Filtro por fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }
        
        $answers = $query->paginate(20);
        
        return view('admin.answers.index', compact('answers'));
    }

    public function show($id)
    {
        $answer = Answers::with('user')->findOrFail($id);
        
        $questionIds = collect($answer->respuestas)
            ->keys()
            ->map(fn ($key) => (int) str_replace('q_', '', $key))
            ->filter(fn ($id) => $id > 0);
        
        $questions = Question::whereIn('id', $questionIds)->get()->keyBy('id');
        
        // Agrupar respuestas por categoría si las preguntas tienen categorías
        $groupedAnswers = [];
        foreach ($answer->respuestas as $key => $value) {
            $questionId = (int) str_replace('q_', '', $key);
            $question = $questions[$questionId] ?? null;
            
            $category = $question->category->name ?? 'Sin categoría';
            $groupedAnswers[$category][] = [
                'question' => $question,
                'answer' => $value,
                'key' => $key
            ];
        }
        
        return view('admin.answers.show', compact('answer', 'questions', 'groupedAnswers'));
    }
    
    public function destroy($id)
    {
        $answer = Answers::findOrFail($id);
        $answer->delete();
        
        return redirect()->route('admin.answers.index')
            ->with('success', 'Respuesta eliminada correctamente.');
    }
    
    public function exportCsv()
    {
        // Método para exportar respuestas
        // (Implementación según necesidades)
    }
}