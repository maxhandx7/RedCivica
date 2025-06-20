@extends('layouts.admin')


@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Actividad Reciente</h1>

        @if ($actividades->isEmpty())
            <div class="alert alert-info">Aún no hay movimientos registrados.</div>
        @else
            <ul class="list-group">
                @foreach ($actividades as $actividad)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="{{ $actividad->icono }}"></i>
                            <strong>{{ $actividad->titulo }}</strong>
                            <br>
                             @if (!$actividad->afectado)
                                                                    {{ $actividad->actor->name }}
                                                                    {{ $actividad->accion }}
                                                                @else
                                                                    <strong>{{ $actividad->afectado->name }}</strong>
                                                                    {{ $actividad->accion }}
                                                                    {{ $actividad->actor->name }}
                                                                @endif
                        </div>
                        <span class="badge bg-secondary">{{ $actividad->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
