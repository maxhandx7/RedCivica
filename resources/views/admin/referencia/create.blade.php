@extends('layouts.admin')


@section('content')
    <div class="container mt-4   p-4 shadow-sm">
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">
                Nueva Campaña
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item"><a href="/referencias">Campañas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva campaña</li>
                </ol>
            </nav>
        </div>

            

        @include('alert.message')
        <form method="POST" action="{{ route('referencias.store') }}">
            @csrf
            <div class="mb-3">
    <label for="campaña_id">Campaña</label>
    <div class="row g-2"> <div class="col"> <select name="campaña_id" id="campaña_id" class="form-select">
                <option value="" selected disabled>Seleccione una campaña...</option>
                @foreach ($campañas as $campaña)
                    <option value="{{ $campaña->id }}" {{ old('campaña_id') == $campaña->id ? 'selected' : '' }}>
                        {{ $campaña->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto"> <a href="{{route('campañas.create')}}" type="button" class="btn btn-primary h-100">
                <span class="fas fa-plus"></span> Añadir
            </a>
            </div>
    </div>
</div>
            <div class="row mb-3">
                <div class="col">
                    <label>Objetivo</label>
                    <textarea name="objetivo" class="form-control" placeholder="Ej: Inscripción votantes" rows="3"></textarea>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>Fuente</label>
                    <input type="text" name="fuente" class="form-control" placeholder="facebook, whatsapp, etc">
                </div>
                <div class="col">
                    <label>Medio</label>
                    <input type="text" name="medio" class="form-control" placeholder="Redes, Impreso, etc">
                </div>
            </div>
            <button class="btn btn-primary w-100">Generar enlace de campaña</button>
        </form>
    </div>
@endsection
