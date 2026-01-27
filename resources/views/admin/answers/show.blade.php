@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 font-weight-bold text-gray-800">
                <i class="fas fa-user-check text-primary"></i> Respuestas de {{ $answer->nombre }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('answers.index') }}">Respuestas</a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('answers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Información del usuario -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-circle"></i> Información Personal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Nombre:</div>
                        <div class="col-7"><strong>{{ $answer->nombre }} {{ $answer->apellido }}</strong></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Documento:</div>
                        <div class="col-7">{{ $answer->tipo_documento }}: {{ $answer->numero_documento }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email:</div>
                        <div class="col-7">
                            <a href="mailto:{{ $answer->email }}">{{ $answer->email }}</a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Ubicación:</div>
                        <div class="col-7">
                            {{ $answer->ciudad }}, {{ $answer->departamento }}<br>
                            <small class="text-muted">{{ $answer->pais }}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Fecha:</div>
                        <div class="col-7">
                            {{ $answer->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    @if($answer->user)
                    <hr>
                    <div class="row">
                        <div class="col-5 text-muted">Usuario asociado:</div>
                        <div class="col-7">
                            <span class="badge badge-success">{{ $answer->user->name }}</span><br>
                            <small>{{ $answer->user->email }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Respuestas -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-list-alt"></i> Respuestas ({{ count($answer->respuestas) }})
                    </h6>
                </div>
                <div class="card-body">
                    @if(isset($groupedAnswers))
                        <!-- Versión agrupada por categorías -->
                        @foreach($groupedAnswers as $category => $respuestas)
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-primary border-bottom pb-2">
                                <i class="fas fa-folder"></i> {{ $category }}
                            </h6>
                            @foreach($respuestas as $respuesta)
                            <div class="card mb-3 border-left-3 border-left-primary">
                                <div class="card-body py-3">
                                    <h6 class="card-title font-weight-bold mb-2">
                                        {{ $loop->iteration }}. {{ $respuesta['question']->question_text ?? 'Pregunta eliminada' }}
                                    </h6>
                                    <div class="alert alert-light bg-light mt-2 mb-0">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-reply"></i> Respuesta:
                                        </small>
                                        <p class="mb-0 pl-3">{{ $respuesta['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    @else
                        <!-- Versión sin agrupar (compatibilidad) -->
                        @foreach($answer->respuestas as $key => $value)
                        @php
                            $questionId = (int) str_replace('q_', '', $key);
                            $question = $questions[$questionId] ?? null;
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">
                                    {{ $loop->iteration }}. {{ $question ? $question->question_text : 'Pregunta eliminada' }}
                                </h6>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <small class="text-muted">Respuesta:</small>
                                    <p class="mb-0 mt-2">{{ $value }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones adicionales -->
    <div class="card shadow mt-4">
        <div class="card-body text-center">
            <a href="{{ route('answers.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
            <button onclick="window.print()" class="btn btn-info mr-2">
                <i class="fas fa-print"></i> Imprimir respuestas
            </button>
            <button onclick="confirmDelete({{ $answer->id }})" class="btn btn-danger">
                <i class="fas fa-trash"></i> Eliminar respuesta
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .breadcrumb, .card-header .btn {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
    }
}
</style>
@endsection