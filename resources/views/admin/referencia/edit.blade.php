@extends('layouts.admin')


@section('content')
    <div class="container mt-4  p-4 shadow-sm">
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">
                Editar Referencia
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item"><a href="/referencias">Referencias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar referencia</li>
                </ol>
            </nav>
        </div>
        @include('alert.message')
        {!! Form::model($referencia, ['route' => ['referencias.update', $referencia], 'method' => 'PUT']) !!}

        <div class="mb-3">
            <label for="campaña_id">Campaña</label>
            <select name="campaña_id" id="campaña_id" class="form-select">
                <option value="" disabled>Seleccione una campaña...</option>
                @foreach ($campañas as $campaña)
                    <option value="{{ $campaña->id }}"
                        {{ old('campaña_id', $referencia->campaña_id ?? '') == $campaña->id ? 'selected' : '' }}>
                        {{ $campaña->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Objetivo</label>
                <textarea name="objetivo" class="form-control @error('objetivo') is-invalid @enderror" placeholder="Ej: Inscripción votantes" rows="3">{{ old('objetivo', $referencia->objetivo ?? '') }}</textarea>
                 @error('objetivo')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Fuente</label>
                <input type="text" name="fuente" class="form-control" placeholder="facebook, whatsapp, etc"
                    value="{{ old('fuente', $referencia->fuente ?? '') }}">
            </div>
            <div class="col">
                <label>Medio</label>
                <input type="text" name="medio" class="form-control" placeholder="Redes, Impreso, etc"
                    value="{{ old('medio', $referencia->medio ?? '') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Actualizar enlace de la referencia</button>
        </form>
    </div>
@endsection
