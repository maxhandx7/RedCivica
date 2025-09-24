<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        return view('admin.questions.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|string',
            'city_id' => 'required|integer',
            'question_text' => 'required|string|max:500',
            'question_type' => 'required|in:multiple_choice,text,rating',
            'is_required' => 'boolean',
            'options' => 'required_if:question_type,multiple_choice|array',
            'options.*' => 'required_if:question_type,multiple_choice|string|max:200'
        ]);

        // Guardar la pregunta
        $question = Question::create([
            'department_id' => $validated['department_id'],
            'city_id' => $validated['city_id'],
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'is_required' => $request->has('is_required'),
            'options' => $validated['question_type'] === 'multiple_choice' ? $validated['options'] : null
        ]);

        return redirect()->route('questions.index')
            ->with('success', 'Pregunta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
