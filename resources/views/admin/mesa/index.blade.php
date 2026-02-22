@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="page-header d-flex justify-content-between">
        <h3 class="page-title">Mesas de Votación</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mesas</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title">Lista de mesas</h4>
        @hasrole('admin')
            <a href="{{ route('mesas.create') }}" class="btn btn-primary me-1 mb-1" type="button">
                <span class="fas fa-plus ms-1" data-fa-transform="shrink-3"></span>
                Nueva Mesa
            </a>
        @endhasrole
    </div>

    @include('alert.message')

    @if ($mesas->isEmpty())
        <div class="alert alert-info">Aún no hay mesas registradas.</div>
    @else
        <div class="table-responsive pt-3">
            <table id="order-listing" class="table mb-0 table-striped data-table fs-10">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Departamento</th>
                        <th>Municipio</th>
                        <th>Puesto de Votación</th>
                        <th>Mesa</th>
                        <th>Zona</th>
                        <th>Usuarios</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mesas as $mesa)
                        <tr>
                            <td>{{ $mesa->id }}</td>
                            <td>{{ $mesa->departamento }}</td>
                            <td>{{ $mesa->municipio }}</td>
                            <td>{{ $mesa->puesto_votacion }}</td>
                            <td>{{ $mesa->mesa }}</td>
                            <td>{{ $mesa->zona }}</td>
                            <td>
                                <span class="badge bg-info">{{ $mesa->users->count() }}</span>
                            </td>
                            <td style="width: 160px;">
                                {!! Form::open([
                                    'route' => ['mesas.destroy', $mesa],
                                    'method' => 'DELETE',
                                    'id' => 'delete-form-' . $mesa->id,
                                ]) !!}

                                <a class="btn btn-outline-info me-1 mb-1 btn-sm"
                                    href="{{ route('mesas.show', $mesa) }}" title="Ver">
                                    <span class="fas fa-eye" data-fa-transform="shrink-3"></span>
                                </a>

                                @hasrole('admin')
                                    <a class="btn btn-outline-success me-1 mb-1 btn-sm"
                                        href="{{ route('mesas.edit', $mesa) }}" title="Editar">
                                        <span class="fas fa-pen" data-fa-transform="shrink-3"></span>
                                    </a>

                                    <button class="btn btn-outline-danger me-1 mb-1 btn-sm" type="submit"
                                        title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de eliminar esta mesa?')">
                                        <span class="fas fa-trash" data-fa-transform="shrink-3"></span>
                                    </button>
                                @endhasrole

                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $mesas->links() }}
        </div>
    @endif
</div>

@endsection

@section('scripts')
    {!! Html::script('melody/js/data-table.js') !!}
@endsection