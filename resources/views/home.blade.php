@extends('layouts.admin')

@section('title', 'RedCivica – Dashboard')

@section('content')
<div class="container py-4">
    @hasrole('admin')
        <!-- INTERFAZ ADMINISTRADOR -->
        <div class="admin-dashboard">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <!-- Tarjeta 1: Referidos Totales -->
                        <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                            <div class="d-flex flex-between-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                        <span class="fs-11 fas fa-users text-primary"></span>
                                    </div>
                                    <h6 class="mb-0">Referidos Totales</h6>
                                </div>
                                <div class="dropdown font-sans-serif btn-reveal-trigger">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                        type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                        <span class="fas fa-ellipsis-h fs-11"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2">
                                        <a class="dropdown-item" href="{{ route('referencias.index') }}">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex">
                                    <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $referidosTotales ?? 0 }}</p>
                                    <div class="d-flex flex-column">
                                        <span class="me-1 fas fa-caret-{{ $referidosTotales > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                        <p class="fs-11 mb-0 text-nowrap">Personas registradas en tu red</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 2: Probabilidad de votación -->
                        <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                            <div class="d-flex flex-between-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                        <span class="fs-11 fas fa-vote-yea text-primary"></span>
                                    </div>
                                    <h6 class="mb-0">Probabilidad de votación</h6>
                                </div>
                                <div class="dropdown font-sans-serif btn-reveal-trigger">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                        type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                        <span class="fas fa-ellipsis-h fs-11"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2">
                                        <a class="dropdown-item" href="{{ route('analitica.index') }}">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex">
                                    <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $probabilidadVoto ?? 80 }}%</p>
                                    <div class="d-flex flex-column">
                                        <span class="me-1 fas fa-caret-{{ $probabilidadVoto > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                        <p class="fs-11 mb-0 text-nowrap">Estimado de participación</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 3: Partidarios activos -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-between-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                        <span class="fs-11 fas fa-hands-helping text-primary"></span>
                                    </div>
                                    <h6 class="mb-0">Partidarios activos</h6>
                                </div>
                                <div class="dropdown font-sans-serif btn-reveal-trigger">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                        type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                        <span class="fas fa-ellipsis-h fs-11"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2">
                                        <a class="dropdown-item" href="{{ route('red.index') }}">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex">
                                    <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $partidariosActivos ?? 0 }}</p>
                                    <div class="d-flex flex-column">
                                        <span class="me-1 fas fa-caret-{{ $partidariosActivos > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                        <p class="fs-11 mb-0 text-nowrap">Usuarios con referidos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario para crear enlaces -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Crear Enlace de campaña</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('referencias.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="campaña_id" class="form-label">Campaña</label>
                                <select name="campaña_id" id="campaña_id" class="form-select" required>
                                    <option value="" selected disabled>Seleccione una campaña...</option>
                                    @foreach ($campañas as $campaña)
                                        <option value="{{ $campaña->id }}" {{ old('campaña_id') == $campaña->id ? 'selected' : '' }}>
                                            {{ $campaña->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="objetivo" class="form-label">Objetivo</label>
                                <textarea name="objetivo" class="form-control" placeholder="Ej: Inscripción votantes" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="fuente" class="form-label">Fuente</label>
                                <input type="text" name="fuente" class="form-control" placeholder="facebook, whatsapp, etc" required>
                            </div>
                            <div class="col">
                                <label for="medio" class="form-label">Medio</label>
                                <input type="text" name="medio" class="form-control" placeholder="Redes, Impreso, etc" required>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100">Generar Enlace</button>
                    </form>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('cliente')
        <!-- INTERFAZ CLIENTE -->
        <div class="client-dashboard">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mi Red de Referidos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Tarjeta simplificada para cliente -->
                        <div class="col-md-12 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="icon-xl bg-success-soft text-success rounded-circle mb-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h3>{{ $referidosTotales ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Personas en mi red</p>
                                    <a href="{{ route('red.index') }}" class="btn btn-sm btn-outline-success mt-3">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                </div>
            </div>

            <!-- Sección de enlaces rápidos para cliente -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('referencias.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i> Ver enlaces de campaña
                        </a>
                        <a href="" class="btn btn-outline-secondary">
                            <i class="fas fa-question-circle me-2"></i> ¿Cómo funciona?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole
</div>
@endsection

@section('styles')
<style>
    .icon-xl {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .client-dashboard .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .client-dashboard .card-header {
        padding: 1rem 1.5rem;
    }
</style>
@endsection