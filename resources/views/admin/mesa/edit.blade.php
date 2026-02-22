@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="page-header d-flex justify-content-between">
        <h3 class="page-title">Editar Mesa de Votación</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.mesa.index') }}">Mesas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>
    </div>

    @include('alert.message')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Mesa #{{ $mesa->id }}</h4>
                    <span class="badge bg-warning text-dark">Editando</span>
                </div>
                <div class="card-body">
                    {!! Form::model($mesa, ['route' => ['admin.mesa.update', $mesa], 'method' => 'PUT']) !!}

                    <div class="row mb-3">
                        <div class="col-md-6">
                            {!! Form::label('departamento', 'Departamento', ['class' => 'form-label']) !!}
                            {!! Form::text('departamento', null, [
                                'class' => 'form-control' . ($errors->has('departamento') ? ' is-invalid' : ''),
                            ]) !!}
                            @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('municipio', 'Municipio', ['class' => 'form-label']) !!}
                            {!! Form::text('municipio', null, [
                                'class' => 'form-control' . ($errors->has('municipio') ? ' is-invalid' : ''),
                            ]) !!}
                            @error('municipio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        {!! Form::label('puesto_votacion', 'Puesto de Votación', ['class' => 'form-label']) !!}
                        {!! Form::text('puesto_votacion', null, [
                            'class' => 'form-control' . ($errors->has('puesto_votacion') ? ' is-invalid' : ''),
                        ]) !!}
                        @error('puesto_votacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            {!! Form::label('mesa', 'Mesa', ['class' => 'form-label']) !!}
                            {!! Form::text('mesa', null, [
                                'class' => 'form-control' . ($errors->has('mesa') ? ' is-invalid' : ''),
                            ]) !!}
                            @error('mesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('zona', 'Zona', ['class' => 'form-label']) !!}
                            {!! Form::text('zona', null, [
                                'class' => 'form-control' . ($errors->has('zona') ? ' is-invalid' : ''),
                            ]) !!}
                            @error('zona')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        {!! Form::label('direccion', 'Dirección', ['class' => 'form-label']) !!}
                        {!! Form::text('direccion', null, [
                            'class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''),
                        ]) !!}
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <span class="fas fa-save me-1"></span> Actualizar Mesa
                        </button>
                        <a href="{{ route('admin.mesa.show', $mesa) }}" class="btn btn-info text-white">
                            <span class="fas fa-eye me-1"></span> Ver detalle
                        </a>
                        <a href="{{ route('admin.mesa.index') }}" class="btn btn-secondary">
                            <span class="fas fa-arrow-left me-1"></span> Volver
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <span class="fas fa-users text-primary me-2"></span>
                        Usuarios en esta mesa
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if ($mesa->users->isEmpty())
                        <div class="p-3 text-muted fs-10">
                            Ningún usuario asignado aún.
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($mesa->users->take(8) as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-10">
                                    <span>{{ $user->name }} {{ $user->surname }}</span>
                                    <span class="text-muted">{{ $user->cedula }}</span>
                                </li>
                            @endforeach
                        </ul>
                        @if ($mesa->users->count() > 8)
                            <div class="p-2 text-center text-muted fs-10">
                                y {{ $mesa->users->count() - 8 }} más...
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection