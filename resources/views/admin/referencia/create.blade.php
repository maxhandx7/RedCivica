@extends('layouts.admin')


@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Crear Nueva Referencia</h1>

    <form method="POST" action="{{ route('referencias.store') }}">
        @csrf
        <div class="mb-3">
            <label>Campaña</label>
            <input type="text" name="campaña" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Objetivo</label>
            <input type="text" name="objetivo" class="form-control">
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>Fuente</label>
                <input type="text" name="fuente" class="form-control">
            </div>
            <div class="col">
                <label>Medio</label>
                <input type="text" name="medio" class="form-control">
            </div>
        </div>
        <button class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
