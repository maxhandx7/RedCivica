@extends('layouts.admin')


@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Mis Referencias Generadas</h1>

    <a href="{{ route('referencias.create') }}" class="btn btn-primary mb-3">Crear Nueva Referencia</a>

    @if($referencias->isEmpty())
        <div class="alert alert-info">Aún no has generado ninguna referencia.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Campaña</th>
                    <th>Objetivo</th>
                    <th>Fuente</th>
                    <th>Medio</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referencias as $ref)
                    <tr>
                        <td>{{ $ref->campaña }}</td>
                        <td>{{ $ref->objetivo }}</td>
                        <td>{{ $ref->fuente }}</td>
                        <td>{{ $ref->medio }}</td>
                        <td>{{ $ref->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
