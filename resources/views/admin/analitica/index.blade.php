@extends('layouts.admin')

@section('title', 'Analítica')

@section('content')

{{-- ══════════════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════════════ --}}
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Panel de Analítica Política</h1>
                <div class="d-flex gap-2 mt-1">
                    <span class="badge bg-soft-primary text-primary">Marketing</span>
                    <span class="badge bg-soft-success text-success">Red Política</span>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Exportar Reporte
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">

    {{-- ══════════════════════════════════════════
         KPI CARDS
         Fuente: $kpis (array desde kpisGlobales())
    ══════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-subtitle mb-1">Links de Marketing</p>
                            <h2 class="mb-0 text-primary">{{ number_format($kpis['total_referencias']) }}</h2>
                            <p class="text-muted small mt-1 mb-0">
                                {{ number_format($kpis['referencias_activas']) }} activos
                            </p>
                        </div>
                        <span class="badge bg-soft-primary rounded-circle p-3">
                            <i class="bi-link-45deg fs-2 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-subtitle mb-1">Usuarios vía Link</p>
                            <h2 class="mb-0 text-success">{{ number_format($kpis['usuarios_desde_referencias']) }}</h2>
                            <p class="text-muted small mt-1 mb-0">Llegaron por campaña</p>
                        </div>
                        <span class="badge bg-soft-success rounded-circle p-3">
                            <i class="bi-people fs-2 text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-subtitle mb-1">Promedio por Link Activo</p>
                            <h2 class="mb-0 text-warning">{{ $kpis['promedio_por_referencia'] }}</h2>
                            <p class="text-muted small mt-1 mb-0">Usuarios por referencia</p>
                        </div>
                        <span class="badge bg-soft-warning rounded-circle p-3">
                            <i class="bi-bar-chart-line fs-2 text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="card-subtitle mb-1">Referidores Activos</p>
                            <h2 class="mb-0 text-info">{{ number_format($kpis['usuarios_con_referidos']) }}</h2>
                            <p class="text-muted small mt-1 mb-0">Con al menos 1 referido</p>
                        </div>
                        <span class="badge bg-soft-info rounded-circle p-3">
                            <i class="bi-diagram-3 fs-2 text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         FILA 1 — Marketing
         Campañas vs Top links específicos
    ══════════════════════════════════════════ --}}
    <div class="row g-3 mb-3">

        {{-- Performance por Campaña --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-header-title">Performance por Campaña</h4>
                    <p class="card-header-subtitle text-muted small mb-0">Links creados y usuarios convertidos</p>
                </div>
                <div class="card-body p-0">
                    @if ($referenciasPorCampaña->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Campaña</th>
                                        <th class="text-end">Links</th>
                                        <th class="text-end">Usuarios</th>
                                        <th class="text-end">% Usuarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referenciasPorCampaña as $campaña)
                                        <tr>
                                            <td>
                                                <span class="legend-indicator bg-primary me-1"></span>
                                                {{ $campaña->name }}
                                            </td>
                                            <td class="text-end">{{ number_format($campaña->total_referencias) }}</td>
                                            <td class="text-end">{{ number_format($campaña->total_usuarios) }}</td>
                                            <td class="text-end">
                                                <span class="badge bg-soft-primary text-primary">
                                                    {{ $kpis['usuarios_desde_referencias'] > 0
                                                        ? number_format(($campaña->total_usuarios / $kpis['usuarios_desde_referencias']) * 100, 1)
                                                        : 0 }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.partials.empty-state', ['title' => 'Sin campañas con datos'])
                    @endif
                </div>
            </div>
        </div>

        {{-- Top 10 links específicos --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-header-title">Top Links de Marketing</h4>
                    <p class="card-header-subtitle text-muted small mb-0">Los 10 links que más usuarios trajeron</p>
                </div>
                <div class="card-body p-0">
                    @if ($topReferencias->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Creado por</th>
                                        <th>Campaña</th>
                                        <th class="text-end">Usuarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topReferencias as $i => $ref)
                                        <tr>
                                            <td class="text-muted">{{ $i + 1 }}</td>
                                            <td>
                                                <a href="{{ route('analitica.usuarios_por_referencia', $ref->id) }}"
                                                   class="text-body fw-semibold">
                                                    {{ optional($ref->user)->name ?? 'Sin usuario' }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-secondary text-secondary">
                                                    {{ optional($ref->campaña)->name ?? 'Sin campaña' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <strong>{{ number_format($ref->usuarios_registrados_count) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.partials.empty-state', ['title' => 'Sin links con conversiones'])
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         FILA 2 — Red Política
         Ranking de quién más ha crecido su red (parent_id)
    ══════════════════════════════════════════ --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Ranking de Referidores — Red Política</h4>
                    <p class="card-header-subtitle text-muted small mb-0">
                        Usuarios con más personas incorporadas directamente a su red
                        <span class="badge bg-soft-info text-info ms-1">Árbol parent_id</span>
                    </p>
                </div>
                <div class="card-body p-0">
                    @if ($rankingReferidores->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th class="text-end">Referidos directos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankingReferidores as $i => $user)
                                        <tr>
                                            <td>
                                                @if ($i === 0)
                                                    <i class="bi-trophy-fill text-warning"></i>
                                                @elseif ($i === 1)
                                                    <i class="bi-trophy-fill text-secondary"></i>
                                                @elseif ($i === 2)
                                                    <i class="bi-trophy-fill text-danger"></i>
                                                @else
                                                    <span class="text-muted">{{ $i + 1 }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-semibold">{{ $user->name }} {{ $user->surname }}</td>
                                            <td class="text-muted">{{ $user->cedula }}</td>
                                            <td class="text-end">
                                                <span class="badge bg-soft-success text-success fs-6">
                                                    {{ number_format($user->children_count) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.partials.empty-state', ['title' => 'Nadie ha referido usuarios aún'])
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection