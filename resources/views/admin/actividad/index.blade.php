@extends('layouts.admin')


@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Actividad Reciente</h1>

    @if($actividades->isEmpty())
        <div class="alert alert-info">Aún no hay movimientos registrados.</div>
    @else
        <ul class="list-group">
            @foreach($actividades as $actividad)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $actividad->actor->name }}</strong>
                        {{ $actividad->accion }}
                        @if($actividad->afectado)
                            <strong>{{ $actividad->afectado->name }}</strong>
                        @endif
                    </div>
                    <span class="badge bg-secondary">{{ $actividad->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
