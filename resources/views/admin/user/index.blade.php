@extends('layouts.admin')
@section('title','Gestión de Usuarios')
@section('styles')
@endsection

@section('options')
@endsection
@section('preference')
@endsection
@section('content')

<div class="container mt-5">
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">
                Usarios
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between">
            <h4 class="card-title">lista de usuarios</h4>
            <div class="btn-group">
                <a href="{{ route('users.create') }}" class="btn btn-primary me-1 mb-1" type="button">
                    <span class="fas fa-plus ms-1" data-fa-transform="shrink-3"></span>
                    Crear usuario</a>
            </div>
        </div>

        @if ($users->isEmpty())
            <div class="alert alert-info">Aún no hay ningun usuario.</div>
        @else
            @include('alert.message')
            <div class="table-responsive  pt-3">
                <table id="order-listing" class="table mb-0 table-striped data-table fs-10">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Mesa</th>
                            <th style="width: 100px;">Creado</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td> <a href="{{route('users.show', $user)}}">{{ $user->cedula }}</a></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mesa }}</td>
                                <td style="width: 100px;">{{ $user->created_at->diffForHumans() }}</td>

                                <td style="width: 160px;">
                                    {!! Form::open([
                                        'route' => ['users.destroy', $user],
                                        'method' => 'DELETE',
                                        'id' => 'delete-form-' . $user->id,
                                    ]) !!}

                                    <a class="btn btn-outline-success me-1 mb-1 btn-sm" href="{{ route('users.edit', $user)}}" type="button"
                                        title="Editar">
                                        <span class="fas fa-pen ms-1" data-fa-transform="shrink-3"></span>
                                        </a>

                                    <button class="btn btn-outline-danger me-1 mb-1 delete-confirm btn-sm" type="submit"
                                        title="Eliminar" onclick="return confirmDelete()">
                                        <span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span>
                                    </button>
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
@section('scripts')
{!! Html::script('melody/js/data-table.js') !!}
@endsection