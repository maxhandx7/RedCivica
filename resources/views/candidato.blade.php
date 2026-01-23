<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <h2 class="h3 fw-bold">Dashboard</h2>
        <p class="text-muted">Panel de control del sistema de candidatos</p>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-1">Candidatos</h6>
                        <h3 class="mb-0">{{ $totalCandidatos }}</h3>
                        <small class="text-white-75">{{ $candidatosActivos }} activos</small>
                    </div>
                    <i class="fas fa-user-tie fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-1">Propuestas</h6>
                        <h3 class="mb-0">{{ $totalPropuestas }}</h3>
                        <small class="text-white-75">{{ $propuestasDestacadas }} destacadas</small>
                    </div>
                    <i class="fas fa-bullhorn fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-1">Tarjetones</h6>
                        <h3 class="mb-0">{{ $totalTarjetones }}</h3>
                        <small class="text-white-75">{{ $tarjetonesActivos }} activos</small>
                    </div>
                    <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-1">Documentos</h6>
                        <h3 class="mb-0">{{ $totalDocumentos }}</h3>
                        <small class="text-white-75">{{ $documentosPublicos }} públicos</small>
                    </div>
                    <i class="fas fa-file-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Candidatos Recientes -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Candidatos Recientes</h5>
                <a href="{{ route('candidatos.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Nuevo Candidato
                </a>
            </div>
            <div class="card-body">
                @if($candidatosRecientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50px"></th>
                                    <th>Candidato</th>
                                    <th>Cargo</th>
                                    <th>Partido</th>
                                    <th>Propuestas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidatosRecientes as $candidato)
                                <tr>
                                    <td>
                                        @if($candidato->imagen)
                                            <img src="{{ Storage::url($candidato->imagen) }}" 
                                                 class="rounded-circle" 
                                                 width="40" 
                                                 height="40" 
                                                 alt="{{ $candidato->nombre_completo }}">
                                        @else
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <span class="text-white fw-bold">{{ $candidato->iniciales }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $candidato->nombre_completo }}</strong><br>
                                        <small class="text-muted">{{ $candidato->alias }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($candidato->cargo) }}</span>
                                    </td>
                                    <td>{{ $candidato->partido }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $candidato->propuestas_count }}</span>
                                    </td>
                                    <td>
                                        @if($candidato->activo)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('candidatos.show', $candidato) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('candidatos.edit', $candidato) }}" 
                                               class="btn btn-outline-secondary" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmarEliminacion(event)" 
                                                    class="btn btn-outline-danger" 
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-tie fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No hay candidatos registrados</p>
                        <a href="" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Crear Primer Candidato
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de Propuestas por Categoría -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Distribución de Propuestas por Categoría</h5>
            </div>
            <div class="card-body">
                <canvas id="categoriasChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de categorías
    const ctx = document.getElementById('categoriasChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($propuestasPorCategoria)),
            datasets: [{
                label: 'Propuestas',
                data: @json(array_values($propuestasPorCategoria)),
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', 
                    '#17a2b8', '#6f42c1', '#e83e8c', '#20c997'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>