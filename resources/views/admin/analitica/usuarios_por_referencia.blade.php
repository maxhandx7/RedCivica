@extends('layouts.admin')

@section('title', 'Usuarios por Referencia')

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">Panel de Analítica Política</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title text-white mb-0">
                                <i class="fas fa-users me-2"></i>Usuarios Registrados por Referencia
                            </h4>
                            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>

                    <!-- Información de la Referencia -->
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-link me-2"></i>Información de la Referencia
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            @if ($referencia->campaña)
                                                <tr>
                                                    <th width="30%" class="bg-light">Campaña de Referencia:</th>
                                                    <td>{{ $referencia->campaña->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Descripcion:</th>
                                                    <td>{{ $referencia->campaña->description ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th class="bg-light">ID Referencia:</th>
                                                <td><span class="badge bg-info">{{ $referencia->id }}</span></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Total Usuarios:</th>
                                                <td>
                                                    <span class="badge bg-success rounded-pill">
                                                        {{ $usuarios->count() }} usuarios
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Usuarios -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-primary mb-0">
                                <i class="fas fa-user-friends me-2"></i>Usuarios Registrados
                            </h5>
                            <div class="d-flex">
                                <input type="text" class="form-control form-control-sm me-2" id="searchInput"
                                    placeholder="Buscar usuario..." style="width: 250px;">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-download me-1"></i> Exportar
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>
                                                Excel</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>
                                                PDF</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if ($usuarios->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="usuariosTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">Nombre</th>
                                            <th width="25%">Email</th>
                                            <th width="20%">Fecha Registro</th>
                                            <th width="15%">Estado</th>
                                            <th width="10%" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $index => $usuario)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3">
                                                            <div class="avatar-title bg-primary rounded-circle text-white d-flex align-items-center justify-content-center"
                                                                style="width: 48px; height: 48px; font-size: 1.4rem; font-weight: 600;">
                                                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $usuario->name }}</strong>
                                                            @if ($usuario->surname)
                                                                <br>
                                                                <small class="text-muted">{{ $usuario->surname }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $usuario->email }}
                                                    {{--  @if ($usuario->email_verified_at)
                                                        <br>
                                                        <small class="text-success">
                                                            <i class="fas fa-check-circle me-1"></i>Verificado
                                                        </small>
                                                    @else
                                                        <br>
                                                        <small class="text-warning">
                                                            <i class="fas fa-clock me-1"></i>Pendiente
                                                        </small>
                                                    @endif --}}
                                                </td>
                                                <td>
                                                    {{ $usuario->created_at->format('d/m/Y') }}
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $usuario->created_at->format('H:i:s') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if ($usuario->estado == 'activo')
                                                        <span class="badge bg-success rounded-pill">
                                                            <i class="fas fa-check me-1"></i>Activo
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger rounded-pill">
                                                            <i class="fas fa-times me-1"></i>Inactivo
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('users.show', $usuario->id) }}"
                                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                            title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('users.edit', $usuario->id) }}"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            data-bs-toggle="tooltip" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Información del total -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-info-circle me-2"></i>
                                            Mostrando <strong>{{ $usuarios->count() }}</strong> usuarios registrados
                                        </div>
                                        @if ($usuarios->count() >= 10)
                                            <a href="#" class="btn btn-outline-info btn-sm">
                                                Ver todos <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-users-slash fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">No hay usuarios registrados</h4>
                                <p class="text-muted mb-4">
                                    No se encontraron usuarios asociados a esta referencia.
                                </p>
                                <a href="{{ url()->previous() }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver atrás
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Footer del Card -->
                    @if ($usuarios->count() > 0)
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Última actualización: {{ now()->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        Sistema de Referencias - Administración
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-sm {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-title {
            font-weight: bold;
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.8rem;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, .125);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inicializar tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Función de búsqueda
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#usuariosTable tbody tr').filter(function() {
                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1
                    );
                });
            });

            // Ordenar tabla al hacer clic en headers
            $('#usuariosTable th').click(function() {
                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                this.asc = !this.asc;
                if (!this.asc) {
                    rows = rows.reverse();
                }
                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i]);
                }
            });

            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index),
                        valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ?
                        valA - valB : valA.toString().localeCompare(valB);
                };
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).text();
            }
        });
    </script>
@endpush
