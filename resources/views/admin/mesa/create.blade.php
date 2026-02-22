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

                    <div class="mb-4">
                        {!! Form::label('direccion', 'Dirección', ['class' => 'form-label']) !!}
                        {!! Form::text('direccion', null, [
                            'class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''),
                            'placeholder' => 'Ej: Calle 50 # 40-20',
                        ]) !!}
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    {{-- Buscador de usuario por cédula --}}
                    <h5 class="mb-3">
                        <span class="fas fa-user-plus text-primary me-2"></span>
                        Asignar Usuario
                        <span class="text-muted fs-10 fw-normal">(opcional)</span>
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Buscar por cédula</label>
                        <div class="input-group">
                            <input type="text" id="cedulaBuscar" class="form-control"
                                placeholder="Ingresa la cédula del usuario">
                            <button class="btn btn-outline-primary" type="button" id="btnBuscarUsuario">
                                <span class="fas fa-search"></span> Buscar
                            </button>
                        </div>
                        <div id="buscarFeedback" class="mt-1"></div>
                    </div>

                    {{-- Tarjeta del usuario encontrado --}}
                    <div id="usuarioEncontrado" class="card border-success mb-3" style="display:none;">
                        <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fas fa-user-check text-success me-2"></span>
                                <strong id="usuarioNombre"></strong>
                                <span class="badge bg-secondary ms-2" id="usuarioCedula"></span>
                                <small class="text-muted ms-2" id="usuarioEmail"></small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="btnLimpiarUsuario"
                                title="Quitar selección">
                                <span class="fas fa-times"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Campo oculto enviado con el form --}}
                    <input type="hidden" name="user_id" id="userIdSeleccionado">

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
                        Completa los datos de la mesa de votación. Opcionalmente busca un usuario por cédula para
                        asignarlo directamente. Solo aparecerán usuarios que aún no tienen mesa asignada.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnBuscar      = document.getElementById('btnBuscarUsuario');
    const inputCedula    = document.getElementById('cedulaBuscar');
    const feedback       = document.getElementById('buscarFeedback');
    const cardEncontrado = document.getElementById('usuarioEncontrado');
    const userIdInput    = document.getElementById('userIdSeleccionado');
    const btnLimpiar     = document.getElementById('btnLimpiarUsuario');

    function limpiarResultado() {
        cardEncontrado.style.display = 'none';
        userIdInput.value = '';
        inputCedula.value = '';
        feedback.innerHTML = '';
    }

    function buscarUsuario() {
        const cedula = inputCedula.value.trim();

        if (!cedula) {
            feedback.innerHTML = '<small class="text-warning"><span class="fas fa-exclamation-circle me-1"></span>Ingresa una cédula para buscar.</small>';
            return;
        }

        feedback.innerHTML = '<small class="text-muted"><span class="fas fa-spinner fa-spin me-1"></span>Buscando...</small>';
        cardEncontrado.style.display = 'none';
        userIdInput.value = '';

        fetch(`{{ route('mesa.buscar-usuario') }}?cedula=${encodeURIComponent(cedula)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json().then(data => ({ ok: res.ok, data })))
        .then(({ ok, data }) => {
            if (!ok) {
                feedback.innerHTML = `<small class="text-danger"><span class="fas fa-times-circle me-1"></span>${data.error}</small>`;
                cardEncontrado.style.display = 'none';
                return;
            }

            document.getElementById('usuarioNombre').textContent = `${data.name} ${data.surname}`;
            document.getElementById('usuarioCedula').textContent = data.cedula;
            document.getElementById('usuarioEmail').textContent  = data.email;
            userIdInput.value = data.id;
            cardEncontrado.style.display = 'block';
            feedback.innerHTML = '<small class="text-success"><span class="fas fa-check-circle me-1"></span>Usuario encontrado y seleccionado.</small>';
        })
        .catch(() => {
            feedback.innerHTML = '<small class="text-danger"><span class="fas fa-exclamation-triangle me-1"></span>Error al conectar con el servidor.</small>';
        });
    }

    btnBuscar.addEventListener('click', buscarUsuario);

    // Enter en el input también busca
    inputCedula.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarUsuario();
        }
    });

    btnLimpiar.addEventListener('click', limpiarResultado);
});
</script>
@endsection