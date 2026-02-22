@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="page-header d-flex justify-content-between">
        <h3 class="page-title">Nueva Mesa de Votación</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mesas.index') }}">Mesas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </nav>
    </div>

    @include('alert.message')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Información de la Mesa</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'mesas.store', 'method' => 'POST']) !!}

                    <div class="row mb-3">
                        <div class="col-md-6">
                            {!! Form::label('departamento', 'Departamento', ['class' => 'form-label']) !!}
                            {!! Form::text('departamento', null, [
                                'class' => 'form-control' . ($errors->has('departamento') ? ' is-invalid' : ''),
                                'placeholder' => 'Ej: Antioquia',
                            ]) !!}
                            @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('municipio', 'Municipio', ['class' => 'form-label']) !!}
                            {!! Form::text('municipio', null, [
                                'class' => 'form-control' . ($errors->has('municipio') ? ' is-invalid' : ''),
                                'placeholder' => 'Ej: Medellín',
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
                            'placeholder' => 'Ej: Colegio San José',
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
                                'placeholder' => 'Ej: 001',
                            ]) !!}
                            @error('mesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('zona', 'Zona', ['class' => 'form-label']) !!}
                            {!! Form::text('zona', null, [
                                'class' => 'form-control' . ($errors->has('zona') ? ' is-invalid' : ''),
                                'placeholder' => 'Ej: Zona Norte',
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
                            'placeholder' => 'Ej: Calle 50 # 40-20',
                        ]) !!}
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <span class="fas fa-save me-1"></span> Guardar Mesa
                        </button>
                        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">
                            <span class="fas fa-arrow-left me-1"></span> Cancelar
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">
                        <span class="fas fa-info-circle text-info me-2"></span>
                        Información
                    </h5>
                    <p class="text-muted fs-10 mb-0">
                        Completa los datos de la mesa de votación. Una vez creada, podrás asignarla a los usuarios registrados en el sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection