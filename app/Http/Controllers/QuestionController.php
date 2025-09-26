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

    public function edit(Question $question)
    {
        try {
            return view('admin.questions.edit', compact('question'));
        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de edición: ' . $e->getMessage());
            return redirect()->route('questions.index')->with('error', 'Error al cargar el formulario de edición');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        try {
            $validated = $request->validate([
                'question_text' => 'required|string|max:500',
                'question_type' => 'required|in:multiple_choice,text,rating',
                'is_required' => 'boolean',
                'options' => 'required_if:question_type,multiple_choice|array|min:2',
                'options.*' => 'required_if:question_type,multiple_choice|string|max:200'
            ], [
                'options.required_if' => 'Las preguntas de opción múltiple deben tener al menos 2 opciones',
                'options.min' => 'Debe haber al menos 2 opciones',
                'options.*.required_if' => 'Todas las opciones deben tener texto',
            ]);

            // Preparar datos para actualizar
            $updateData = [
                'department_id' => $validated['department_id'],
                'city_id' => $validated['city_id'],
                'question_text' => $validated['question_text'],
                'question_type' => $validated['question_type'],
                'is_required' => $request->has('is_required'),
            ];

            // Manejar opciones según el tipo de pregunta
            if ($validated['question_type'] === 'multiple_choice') {
                // Filtrar opciones vacías
                $filteredOptions = array_filter($validated['options'], function ($option) {
                    return !empty(trim($option));
                });

                if (count($filteredOptions) < 2) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Las preguntas de opción múltiple deben tener al menos 2 opciones válidas');
                }

                $updateData['options'] = $filteredOptions;
            } else {
                $updateData['options'] = null;
            }

            // Actualizar la pregunta
            $question->update($updateData);

            return redirect()->route('questions.index')
                ->with('success', 'Pregunta actualizada exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Por favor corrige los errores en el formulario');
        } catch (\Exception $e) {
        
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la pregunta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        try {
            $question->delete();

            return redirect()->route('questions.index')
                ->with('success', 'Pregunta eliminada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar pregunta: ' . $e->getMessage());
            return redirect()->route('questions.index')
                ->with('error', 'Error al eliminar la pregunta');
        }
    }

    /**
     * Obtener departamentos de Colombia desde Geonames (API endpoint)
     */
    public function getDepartments()
    {
        try {
            $colombiaGeonameId = 3686110;
            $username = 'Alan';

            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://secure.geonames.org/childrenJSON", [
                'query' => [
                    'geonameId' => $colombiaGeonameId,
                    'username' => $username
                ],
                'timeout' => 10
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['geonames']) && count($data['geonames']) > 0) {
                // Filtrar departamentos (nivel administrativo 1)
                $departments = array_filter($data['geonames'], function ($place) {
                    return $place['fcode'] === 'ADM1' || isset($place['adminCode1']);
                });

                return response()->json([
                    'success' => true,
                    'departments' => array_values($departments)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron departamentos',
                    'departments' => $this->getDefaultDepartments()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener departamentos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar departamentos',
                'departments' => $this->getDefaultDepartments()
            ]);
        }
    }

    /**
     * Obtener ciudades por departamento desde Geonames (API endpoint)
     */
    public function getCities($departmentCode)
    {
        try {
            $username = 'Alan';

            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://secure.geonames.org/searchJSON", [
                'query' => [
                    'country' => 'CO',
                    'adminCode1' => $departmentCode,
                    'maxRows' => 100,
                    'username' => $username,
                    'featureClass' => 'P' // Solo lugares poblados
                ],
                'timeout' => 10
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['geonames']) && count($data['geonames']) > 0) {
                return response()->json([
                    'success' => true,
                    'cities' => $data['geonames']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron ciudades',
                    'cities' => $this->getDefaultCities($departmentCode)
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener ciudades: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar ciudades',
                'cities' => $this->getDefaultCities($departmentCode)
            ]);
        }
    }

    /**
     * Departamentos por defecto en caso de error
     */
    private function getDefaultDepartments()
    {
        return [
            ['geonameId' => 'ANT', 'name' => 'Antioquia', 'adminCode1' => 'ANT'],
            ['geonameId' => 'CUN', 'name' => 'Cundinamarca', 'adminCode1' => 'CUN'],
            ['geonameId' => 'VAL', 'name' => 'Valle del Cauca', 'adminCode1' => 'VAL'],
            ['geonameId' => 'ATL', 'name' => 'Atlántico', 'adminCode1' => 'ATL'],
            ['geonameId' => 'BOL', 'name' => 'Bolívar', 'adminCode1' => 'BOL'],
            ['geonameId' => 'SAN', 'name' => 'Santander', 'adminCode1' => 'SAN'],
            ['geonameId' => 'BOY', 'name' => 'Boyacá', 'adminCode1' => 'BOY']
        ];
    }

    /**
     * Ciudades por defecto en caso de error
     */
    private function getDefaultCities($departmentCode)
    {
        $cities = [
            'ANT' => [
                ['geonameId' => 3687925, 'name' => 'Medellín'],
                ['geonameId' => 3680656, 'name' => 'Bello'],
                ['geonameId' => 3674962, 'name' => 'Itagüí']
            ],
            'CUN' => [
                ['geonameId' => 3688689, 'name' => 'Bogotá'],
                ['geonameId' => 3671325, 'name' => 'Soacha'],
                ['geonameId' => 3673899, 'name' => 'Zipaquirá']
            ],
            'VAL' => [
                ['geonameId' => 3687925, 'name' => 'Cali'],
                ['geonameId' => 3671546, 'name' => 'Palmira'],
                ['geonameId' => 3679065, 'name' => 'Buenaventura']
            ]
        ];

        return $cities[$departmentCode] ?? [
            ['geonameId' => 1, 'name' => 'Ciudad principal'],
            ['geonameId' => 2, 'name' => 'Otra ciudad']
        ];
    }

public function byLocation(Request $request)
{
    

    $questions = Question::where('department_id', $request->department_id)
        ->where('city_id', $request->city_id)
        ->get(['id','question_text','question_type','options','is_required']);

      
    return response()->json([
        'success'   => true,
        'questions' => $questions
    ]);
}
 

}
