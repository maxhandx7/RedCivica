@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="page-header d-flex justify-content-between">
        <h3 class="page-title">Detalle de Mesa</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mesas.index') }}">Mesas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalle</li>
            </ol>
        </nav>
    </div>

    @include('alert.message')

    <div class="row">
        {{-- Info de la mesa --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Mesa #{{ $mesa->id }}</h5>
                    <span class="badge bg-primary">{{ $mesa->mesa }}</span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Departamento</span>
                            <strong>{{ $mesa->departamento ?? '—' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Municipio</span>
                            <strong>{{ $mesa->municipio ?? '—' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Puesto de Votación</span>
                            <strong>{{ $mesa->puesto_votacion ?? '—' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Zona</span>
                            <strong>{{ $mesa->zona ?? '—' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Dirección</span>
                            <strong> <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($mesa->direccion) }}"
                                target="_blank" class="text-decoration-none text-dark"></a> </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fs-10">
                            <span class="text-muted">Total usuarios</span>
                            <span class="badge bg-info">{{ $mesa->users->count() }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer d-flex gap-2">
                    @hasrole('admin')
                        <a href="{{ route('mesas.edit', $mesa) }}" class="btn btn-outline-success btn-sm">
                            <span class="fas fa-pen me-1"></span> Editar
                        </a>

                        {!! Form::open(['route' => ['mesas.destroy', $mesa], 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta mesa?')">
                                <span class="fas fa-trash me-1"></span> Eliminar
                            </button>
                        {!! Form::close() !!}
                    @endhasrole

                    <a href="{{ route('mesas.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                        <span class="fas fa-arrow-left me-1"></span> Volver
                    </a>
                </div>
            </div>
        </div>

        {{-- Usuarios asignados a esta mesa --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <span class="fas fa-users text-primary me-2"></span>
                        Usuarios asignados
                    </h5>
                    <span class="badge bg-secondary">{{ $mesa->users->count() }} usuarios</span>
                </div>

                @if ($mesa->users->isEmpty())
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            No hay usuarios asignados a esta mesas.
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 fs-10">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th>Estado</th>
                                    <th>Referido por</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mesa->users as $user)
                                    <tr>
                                        <td> <a href="{{ route('users.show', $user ) }}">{{ $user->cedula }}</a> </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->surname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->estado == 'activo')
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->parent)
                                                {{ $user->parent->name }} {{ $user->parent->surname }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('melody/js/data-table.js') !!}
@endsection