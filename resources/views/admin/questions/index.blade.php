@extends('layouts.admin')
@section('title', 'Gestión de Preguntas')
@section('styles')
    <link href="{{ asset('falcon/css/tabler.min.css') }}" rel="stylesheet">
    <style>
        .campaign-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .table-responsive {
            min-height: 300px;
        }

        .search-box {
            max-width: 300px;
        }

      
    </style>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Preguntas por Ciudad</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm search-box">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control form-control-sm" placeholder="Buscar..."
                            id="search-input">
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('questions.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Agregar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            @include('alert.message')
            <div class="table-responsive">
                <div id="question-table" 
                data-list='{"valueNames":["departamento","ciudad","pregunta","tipo","obligatoria"],
                "page":10,
                "pagination":true}'>
                    <table class="table table-sm table-hover table-striped mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort" data-sort="departamento">Departamento</th>
                                <th class="sort" data-sort="ciudad">Ciudad</th>
                                <th class="sort" data-sort="pregunta">Pregunta</th>
                                <th class="sort" data-sort="tipo">Tipo</th>
                                <th class="sort" data-sort="obligatoria">Obligatoria</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($questions as $question)
                                <tr>
                                    <td class="departamento">
                                        <span class="text-primary"
                                            id="department-{{ $question->id }}">Cargando...</span>
                                    </td>
                                    <td class="ciudad">
                                        <span class="text-primary" id="city-{{ $question->id }}">Cargando...</span>
                                    </td>
                                    <td class="pregunta">{{ $question->question_text }}</td>
                                    <td class="tipo">
                                        @if ($question->question_type == 'multiple_choice')
                                            <span class="badge bg-primary">Opción Múltiple</span>
                                        @elseif($question->question_type == 'text')
                                            <span class="badge bg-info">Texto</span>
                                        @else
                                            <span class="badge bg-warning">Calificación</span>
                                        @endif
                                    </td>
                                    <td class="obligatoria">
                                        @if ($question->is_required)
                                            <span class="badge bg-success">Sí</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('questions.show', $question) }}" class="btn btn-sm btn-link"
                                                data-bs-toggle="tooltip" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-link"
                                                data-bs-toggle="tooltip" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {!! Form::open(['route' => ['questions.destroy', $question], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                            <button type="submit" class="btn btn-sm btn-link text-danger"
                                                data-bs-toggle="tooltip" title="Eliminar"
                                                onclick="return confirm('¿Estás seguro?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if ($questions->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        {{ $questions->links('pagination::bootstrap-4') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')



    <script>
document.addEventListener('DOMContentLoaded', function() {
    const username = 'Alan';

   


    // Ordenamiento por columnas
    document.querySelectorAll('.sort').forEach(header => {
        header.addEventListener('click', () => {
            const column = header.getAttribute('data-sort');
            questionList.sort(column, {
                order: questionList.sorting.order === 'asc' ? 'desc' : 'asc'
            });
        });
    });

    // Cargar nombres de departamentos y ciudades
    function loadLocationNames() {
        @foreach ($questions as $question)
            loadCityName({{ $question->id }}, {{ $question->city_id }});
        @endforeach
    }

    function loadCityName(questionId, cityId) {
        fetch(`https://secure.geonames.org/getJSON?geonameId=${cityId}&username=${username}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById(`city-${questionId}`).textContent =
                    data?.name ?? `Ciudad ID: ${cityId}`;
                document.getElementById(`department-${questionId}`).textContent =
                    data?.adminName1 ?? 'No encontrado';
            })
            .catch(err => {
                console.error('Error cargando ciudad:', err);
                document.getElementById(`city-${questionId}`).textContent = `Error (ID: ${cityId})`;
                document.getElementById(`department-${questionId}`).textContent = 'Error';
            });
    }

    loadLocationNames();
});
</script>

@endsection
