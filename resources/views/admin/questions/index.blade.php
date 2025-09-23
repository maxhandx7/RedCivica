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
                <h5 class="mb-0">Preguntas</h5>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm search-box">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar..." id="search-input">
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
            <table class="table table-sm table-hover table-striped mb-0" id="question-table">
                <thead class="bg-200">
                    <tr>
                        <th class="sort" id="ciudad" data-sort="ciudad">Ciudad</th>
                        <th class="sort" data-sort="pregunta">Pregunta</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($questions as $question)
                    <tr>
                        <td class="ciudad">{{ $question->city_id }}</td>
                        <td class="pregunta">{{$question->question_text }}</td>
                       
                      
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-link" data-bs-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['questions.destroy', $question], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                <button type="submit" class="btn btn-sm btn-link text-danger" data-bs-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Estás seguro?')">
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
        
        <!-- Paginación simple -->
       {{--  @if($questions->hasPages())
        <div class="d-flex justify-content-center mt-3">
            <nav>
                {{ $questions->links('pagination::bootstrap-4') }}
            </nav>
        </div>
        @endif --}}
    </div>
</div>
@endsection

@section('scripts')
{!! Html::script('/falcon/public/vendors/sortablejs/Sortable.min.js') !!}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar List.js
    var options = {
        valueNames: ['city_id', 'question_text'],
        page: 10,
        pagination: true
    };
    
    var questionList = new List('question-table', options);
    
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Ordenamiento por columnas
    document.querySelectorAll('.sort').forEach(header => {
        header.addEventListener('click', () => {
            const column = header.getAttribute('data-sort');
            questionList.sort(column, { order: questionList.sorting.order === 'asc' ? 'desc' : 'asc' });
        });
    });
});
</script>
@endsection