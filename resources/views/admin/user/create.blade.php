@extends('layouts.admin')
@section('title', 'Nuevo Usuario')
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
                Nuevo usuario
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo usuarios</li>
                </ol>
            </nav>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                @include('admin.form.__form')
                            </div>
                            
                            <a href="{{ route('users.index') }}" class="btn btn-light">
                                Cancelar
                            </a>
                           

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')



@endsection
