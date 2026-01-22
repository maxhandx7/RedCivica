@extends('layouts.admin')

@section('title', $candidato->nombre_completo)

@section('content')
{!! Html::style('/css/admin.css') !!}
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 fw-bold mb-1">{{ $candidato->nombre_completo }}</h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info">{{ ucfirst($candidato->cargo) }}</span>
                    <span class="text-muted">{{ $candidato->partido }}</span>
                    @if($candidato->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </div>
            </div>
            <div class="btn-group">
                <a href="{{ route('candidatos.edit', $candidato) }}" class="btn btn-secondary">
                    <i class="fas fa-edit me-2"></i> Editar
                </a>
                <a href="{{ route('candidatos.propuestas.index', $candidato) }}" class="btn btn-primary">
                    <i class="fas fa-bullhorn me-2"></i> Propuestas
                </a>
                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                    Más opciones
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('candidatos.toggle-activo', $candidato) }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                @if($candidato->activo)
                                    <i class="fas fa-times me-2"></i> Desactivar
                                @else
                                    <i class="fas fa-check me-2"></i> Activar
                                @endif
                            </button>
                        </form>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('candidatos.metricas', $candidato) }}">
                        <i class="fas fa-chart-line me-2"></i> Métricas
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('candidatos.destroy', $candidato) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar este candidato?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-trash me-2"></i> Eliminar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid {{ $candidato->color_principal }};">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Propuestas</h6>
                        <h3 class="mb-0">{{ $estadisticas['total_propuestas'] }}</h3>
                    </div>
                    <i class="fas fa-bullhorn fa-2x" style="color: {{ $candidato->color_principal }};"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Tarjetones</h6>
                        <h3 class="mb-0">{{ $estadisticas['total_tarjetones'] }}</h3>
                    </div>
                    <i class="fas fa-clipboard-list fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Documentos</h6>
                        <h3 class="mb-0">{{ $estadisticas['total_documentos'] }}</h3>
                    </div>
                    <i class="fas fa-file-alt fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #17a2b8;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Categorías</h6>
                        <h3 class="mb-0">{{ count($estadisticas['propuestas_por_categoria']) }}</h3>
                    </div>
                    <i class="fas fa-tags fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Perfil del Candidato -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(90deg, {{ $candidato->color_principal }} 0%, #ffffff 100%);">
                <h5 class="mb-0 text-white">Perfil</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if($candidato->imagen)
                        <img src="{{ Storage::url($candidato->imagen) }}" 
                             alt="{{ $candidato->nombre_completo }}" 
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid {{ $candidato->color_principal }};">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 150px; height: 150px; background-color: {{ $candidato->color_principal }}20; border: 4px solid {{ $candidato->color_principal }};">
                            <span class="display-4 fw-bold" style="color: {{ $candidato->color_principal }};">
                                {{ $candidato->iniciales }}
                            </span>
                        </div>
                    @endif
                    
                    <h4>{{ $candidato->nombre_completo }}</h4>
                    @if($candidato->alias)
                        <p class="text-muted mb-1">"{{ $candidato->alias }}"</p>
                    @endif
                    
                    @if($candidato->lema)
                        <div class="alert alert-light mt-3" style="border-left: 4px solid {{ $candidato->color_principal }};">
                            <i class="fas fa-quote-left me-2" style="color: {{ $candidato->color_principal }};"></i>
                            {{ $candidato->lema }}
                        </div>
                    @endif
                </div>
                
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user-tie me-2 text-primary"></i> Cargo</span>
                        <span class="badge bg-primary">{{ ucfirst($candidato->cargo) }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-map-marker-alt me-2 text-success"></i> Circunscripción</span>
                        <span>{{ $candidato->circunscripcion }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-flag me-2 text-warning"></i> Partido</span>
                        <span>{{ $candidato->partido }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar-alt me-2 text-info"></i> Elección</span>
                        <span>{{ $candidato->fecha_eleccion->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-sort-numeric-up me-2 text-secondary"></i> Orden</span>
                        <span class="badge bg-secondary">{{ $candidato->orden }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Propuestas por Categoría -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Propuestas por Categoría</h5>
            </div>
            <div class="card-body">
                @if($candidato->propuestas->count() > 0)
                    <canvas id="categoriasChart" height="150"></canvas>
                    
                    <div class="mt-4">
                        <h6>Distribución:</h6>
                        <div class="row">
                            @foreach($estadisticas['propuestas_por_categoria'] as $categoria => $total)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-capitalize">{{ str_replace('_', ' ', $categoria) }}</span>
                                    <span class="badge bg-secondary">{{ $total }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" 
                                         role="progressbar" 
                                         style="width: {{ ($total / $estadisticas['total_propuestas']) * 100 }}%"
                                         aria-valuenow="{{ $total }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $estadisticas['total_propuestas'] }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Este candidato no tiene propuestas registradas</p>
                        <a href="{{ route('candidatos.propuestas.create', $candidato) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Agregar Propuestas
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Biografía -->
    @if($candidato->biografia)
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Biografía</h5>
            </div>
            <div class="card-body">
                <div class="text-muted">
                    {!! nl2br(e($candidato->biografia)) !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Propuestas Recientes -->
    @if($candidato->propuestas->count() > 0)
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Propuestas Recientes</h5>
                <a href="{{ route('candidatos.propuestas.index', $candidato) }}" class="btn btn-sm btn-primary">
                    Ver todas <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($candidato->propuestas->take(4) as $propuesta)
                    <div class="col">
                        <div class="card propuesta-card h-100" style="border-left-color: {{ $propuesta->color }};">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="avatar avatar-md me-3">
                                        <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center"
                                             style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                            <i class="{{ $propuesta->icono }} fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $propuesta->titulo }}</h6>
                                        <span class="badge badge-categoria" 
                                              style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                            {{ $propuesta->categoria_formateada }}
                                        </span>
                                        @if($propuesta->destacada)
                                            <span class="badge bg-warning ms-1">Destacada</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="card-text text-muted mb-0" style="font-size: 0.9rem;">
                                    {{ Str::limit($propuesta->descripcion, 150) }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-sort-numeric-up me-1"></i> Orden: {{ $propuesta->orden }}
                                    </small>
                                    <a href=" {{ route('candidatos.propuestas.edit', [$candidato, $propuesta]) }} " 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@if($candidato->propuestas->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de categorías
    const ctx = document.getElementById('categoriasChart').getContext('2d');
    
    // Preparar datos
    const categorias = @json(array_keys($estadisticas['propuestas_por_categoria']->toArray()));
    const datos = @json(array_values($estadisticas['propuestas_por_categoria']->toArray()));
    
    // Colores para las categorías
    const colores = [
        '#007bff', '#28a745', '#ffc107', '#dc3545', 
        '#17a2b8', '#6f42c1', '#e83e8c', '#20c997',
        '#fd7e14', '#6c757d'
    ];
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categorias.map(cat => cat.charAt(0).toUpperCase() + cat.slice(1).replace('_', ' ')),
            datasets: [{
                data: datos,
                backgroundColor: colores.slice(0, categorias.length),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} propuesta${value !== 1 ? 's' : ''} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif