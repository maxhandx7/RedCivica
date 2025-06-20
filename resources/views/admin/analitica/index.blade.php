@extends('layouts.admin')

@section('title', 'Analítica')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">Panel de Analítica Política</h1>
                    <div class="row">
                        <div class="col-auto">
                            <span class="badge bg-soft-primary text-primary">Referencias</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-soft-success text-success">Conversiones</span>
                        </div>
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
    <!-- End Page Header -->

    <div class="container">
        <!-- Stats -->
        <div class="row gx-2 gx-lg-3 mb-4">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle">Referencias Totales</h6>
                                <h2 class="text-primary">{{ number_format($totalReferencias) }}</h2>
                            </div>
                            <span class="badge bg-soft-primary rounded-circle p-3">
                                <i class="bi-link-45deg fs-2 text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle">Usuarios desde Referencias</h6>
                                <h2 class="text-success">{{ number_format($usuariosDesdeReferencias) }}</h2>
                            </div>
                            <span class="badge bg-soft-success rounded-circle p-3">
                                <i class="bi-people fs-2 text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-sm-0">
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle">promedio referidos</h6>
                                <h2 class="text-warning">{{ $conversion }}%</h2>
                            </div>
                            <span class="badge bg-soft-warning rounded-circle p-3">
                                <i class="bi-percent fs-2 text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle">Usuarios con Referidos</h6>
                                <h2 class="text-info">{{ number_format($usuariosConReferidos) }}</h2>
                            </div>
                            <span class="badge bg-soft-info rounded-circle p-3">
                                <i class="bi-person-plus fs-2 text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Stats -->

        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card card-hover-shadow h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-header-title">Referencias por Campaña</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($referenciasPorCampaña->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Campaña</th>
                                            <th class="text-end">Referencias</th>
                                            <th class="text-end">% del total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($referenciasPorCampaña as $name => $total)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="legend-indicator bg-primary"></span>
                                                        {{ $name ?: 'Sin campaña' }}
                                                    </div>
                                                </td>
                                                <td class="text-end">{{ number_format($total) }}</td>
                                                <td class="text-end">
                                                    {{ $totalReferencias > 0 ? round(($total / $totalReferencias) * 100, 1) : 0 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <img class="img-fluid mb-3"
                                    src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}" alt="No data"
                                    style="max-width: 200px;">
                                <h5>No hay campañas con referencias</h5>
                                <p class="mb-0">Parece que no hay datos disponibles todavía</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card card-hover-shadow h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-header-title">Usuarios por Referencia</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($usuariosPorReferencia->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID Referencia</th>
                                            <th class="text-end">Usuarios</th>
                                            <th class="text-end">% del total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuariosPorReferencia as $refId => $total)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="legend-indicator bg-success"></span>
                                                        {{ $refId }}
                                                    </div>
                                                </td>
                                                <td class="text-end">{{ number_format($total) }}</td>
                                                <td class="text-end">
                                                    {{ $usuariosDesdeReferencias > 0 ? round(($total / $usuariosDesdeReferencias) * 100, 1) : 0 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <img class="img-fluid mb-3"
                                    src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}" alt="No data"
                                    style="max-width: 200px;">
                                <h5>No hay registros desde referencias</h5>
                                <p class="mb-0">Parece que no hay datos disponibles todavía</p>
                            </div>
                        @endif
                    </div>

                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
@endsection
