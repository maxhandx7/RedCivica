<!-- resources/views/admin/candidatos/metricas.blade.php -->
@extends('layouts.admin')

@section('title', 'Métricas - ' . $candidato->nombre_completo)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 fw-bold mb-1">Métricas y Estadísticas</h2>
                <p class="text-muted mb-0">
                    Candidato: 
                    <a href="{{ route('candidatos.show', $candidato) }}" class="text-decoration-none">
                        {{ $candidato->nombre_completo }}
                    </a>
                </p>
            </div>
            <div class="btn-group">
                <a href="{{ route('candidatos.show', $candidato) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarMetricaModal">
                    <i class="fas fa-plus me-2"></i> Nueva Métrica
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Resumen de Métricas -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #007bff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Métricas</h6>
                        <h3 class="mb-0">{{ $metricas->count() }}</h3>
                    </div>
                    <i class="fas fa-chart-bar fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Tipos Únicos</h6>
                        <h3 class="mb-0">{{ $tiposMetricas->count() }}</h3>
                    </div>
                    <i class="fas fa-tags fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Última Medición</h6>
                        <h6 class="mb-0" style="font-size: 1rem;">
                            {{ $metricas->first() ? $metricas->first()->fecha_medicion->diffForHumans() : 'N/A' }}
                        </h6>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Promedio Mensual</h6>
                        <h6 class="mb-0" style="font-size: 1rem;">
                            {{ $metricas->count() > 0 ? round($metricas->count() / 3, 1) : '0' }}
                        </h6>
                    </div>
                    <i class="fas fa-chart-line fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('candidatos.metricas', $candidato) }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="tipo_metrica" class="form-label">Tipo de Métrica</label>
                        <select name="tipo_metrica" id="tipo_metrica" class="form-select">
                            <option value="">Todos los tipos</option>
                            @foreach($tiposMetricas as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo_metrica') == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                        <input type="date" 
                               name="fecha_desde" 
                               id="fecha_desde" 
                               class="form-control" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" 
                               name="fecha_hasta" 
                               id="fecha_hasta" 
                               class="form-control" 
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('candidatos.metricas', $candidato) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Evolución de Métricas</h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="exportChart">
                        <i class="fas fa-download me-1"></i> Exportar
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="metricasChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Métricas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Registro de Métricas</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="exportExcel">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="exportPdf">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($metricas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" id="metricas-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                    <th>Unidad</th>
                                    <th>Tendencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($metricas as $metrica)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $metrica->fecha_medicion->translatedFormat('d M Y') }}</strong>
                                            <small class="text-muted">{{ $metrica->fecha_medicion->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $metrica->tipo_metrica)) }}
                                        </span>
                                    </td>
                                    <td>{{ $metrica->nombre }}</td>
                                    <td>
                                        <strong>{{ number_format($metrica->valor, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($metrica->unidad)
                                            <span class="badge bg-secondary">{{ $metrica->unidad }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            // Calcular tendencia (simplificado)
                                            $tendencia = '';
                                            $color = '';
                                            if($loop->index > 0) {
                                                $anterior = $metricas[$loop->index - 1];
                                                if($anterior->tipo_metrica == $metrica->tipo_metrica) {
                                                    $diferencia = $metrica->valor - $anterior->valor;
                                                    $porcentaje = $anterior->valor != 0 ? ($diferencia / $anterior->valor) * 100 : 0;
                                                    
                                                    if($diferencia > 0) {
                                                        $tendencia = '↑ ' . number_format($porcentaje, 1) . '%';
                                                        $color = 'text-success';
                                                    } elseif($diferencia < 0) {
                                                        $tendencia = '↓ ' . number_format(abs($porcentaje), 1) . '%';
                                                        $color = 'text-danger';
                                                    } else {
                                                        $tendencia = '→ 0%';
                                                        $color = 'text-muted';
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if($tendencia)
                                            <span class="{{ $color }} fw-bold">
                                                <i class="fas {{ $diferencia > 0 ? 'fa-arrow-up' : ($diferencia < 0 ? 'fa-arrow-down' : 'fa-minus') }} me-1"></i>
                                                {{ $tendencia }}
                                            </span>
                                        @else
                                            <span class="text-muted">Nueva</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" 
                                                    class="btn btn-outline-info" 
                                                    title="Detalles"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detalleMetricaModal{{ $metrica->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-outline-warning" 
                                                    title="Editar"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editarMetricaModal{{ $metrica->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form action="{{ route('candidatos.metricas.destroy', [$candidato, $metrica]) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmarEliminacion(event)" 
                                                        class="btn btn-outline-danger" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Modal Detalles -->
                                        <div class="modal fade" id="detalleMetricaModal{{ $metrica->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detalles de la Métrica</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <strong>Tipo:</strong><br>
                                                                <span class="badge bg-info">
                                                                    {{ ucfirst(str_replace('_', ' ', $metrica->tipo_metrica)) }}
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong>Fecha:</strong><br>
                                                                {{ $metrica->fecha_medicion->translatedFormat('d F Y') }}
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <strong>Nombre:</strong><br>
                                                                {{ $metrica->nombre }}
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong>Valor:</strong><br>
                                                                <h4 class="mb-0">{{ number_format($metrica->valor, 2) }}</h4>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong>Unidad:</strong><br>
                                                                @if($metrica->unidad)
                                                                    <span class="badge bg-secondary">{{ $metrica->unidad }}</span>
                                                                @else
                                                                    <span class="text-muted">Sin unidad</span>
                                                                @endif
                                                            </div>
                                                            @if($metrica->metadata)
                                                                <div class="col-12 mb-3">
                                                                    <strong>Metadatos:</strong><br>
                                                                    <pre class="bg-light p-2 rounded" style="font-size: 0.85rem;">{{ json_encode($metrica->metadata, JSON_PRETTY_PRINT) }}</pre>
                                                                </div>
                                                            @endif
                                                            <div class="col-12">
                                                                <strong>Creada:</strong><br>
                                                                {{ $metrica->created_at->translatedFormat('d F Y H:i') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal Editar -->
                                        <div class="modal fade" id="editarMetricaModal{{ $metrica->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('candidatos.metricas.update', [$candidato, $metrica]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Editar Métrica</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="tipo_metrica{{ $metrica->id }}" class="form-label">Tipo *</label>
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       id="tipo_metrica{{ $metrica->id }}" 
                                                                       name="tipo_metrica" 
                                                                       value="{{ $metrica->tipo_metrica }}" 
                                                                       required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nombre{{ $metrica->id }}" class="form-label">Nombre *</label>
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       id="nombre{{ $metrica->id }}" 
                                                                       name="nombre" 
                                                                       value="{{ $metrica->nombre }}" 
                                                                       required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="valor{{ $metrica->id }}" class="form-label">Valor *</label>
                                                                    <input type="number" 
                                                                           step="0.01" 
                                                                           class="form-control" 
                                                                           id="valor{{ $metrica->id }}" 
                                                                           name="valor" 
                                                                           value="{{ $metrica->valor }}" 
                                                                           required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="unidad{{ $metrica->id }}" class="form-label">Unidad</label>
                                                                    <input type="text" 
                                                                           class="form-control" 
                                                                           id="unidad{{ $metrica->id }}" 
                                                                           name="unidad" 
                                                                           value="{{ $metrica->unidad }}">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="fecha_medicion{{ $metrica->id }}" class="form-label">Fecha de Medición *</label>
                                                                <input type="date" 
                                                                       class="form-control" 
                                                                       id="fecha_medicion{{ $metrica->id }}" 
                                                                       name="fecha_medicion" 
                                                                       value="{{ $metrica->fecha_medicion->format('Y-m-d') }}" 
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    @if($metricas->hasPages())
                    <div class="mt-3">
                        {{ $metricas->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No hay métricas registradas para este candidato</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarMetricaModal">
                            <i class="fas fa-plus me-1"></i> Agregar Primera Métrica
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Métrica -->
<div class="modal fade" id="agregarMetricaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('candidatos.metricas.store', $candidato) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nueva Métrica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo_metrica" class="form-label">Tipo de Métrica *</label>
                        <select class="form-select @error('tipo_metrica') is-invalid @enderror" 
                                id="tipo_metrica" 
                                name="tipo_metrica" 
                                required>
                            <option value="">Seleccionar tipo...</option>
                            <option value="intencion_voto" {{ old('tipo_metrica') == 'intencion_voto' ? 'selected' : '' }}>Intención de Voto</option>
                            <option value="reconocimiento" {{ old('tipo_metrica') == 'reconocimiento' ? 'selected' : '' }}>Reconocimiento</option>
                            <option value="popularidad" {{ old('tipo_metrica') == 'popularidad' ? 'selected' : '' }}>Popularidad</option>
                            <option value="redes_sociales" {{ old('tipo_metrica') == 'redes_sociales' ? 'selected' : '' }}>Redes Sociales</option>
                            <option value="eventos" {{ old('tipo_metrica') == 'eventos' ? 'selected' : '' }}>Eventos</option>
                            <option value="donaciones" {{ old('tipo_metrica') == 'donaciones' ? 'selected' : '' }}>Donaciones</option>
                            <option value="voluntarios" {{ old('tipo_metrica') == 'voluntarios' ? 'selected' : '' }}>Voluntarios</option>
                            <option value="encuestas" {{ old('tipo_metrica') == 'encuestas' ? 'selected' : '' }}>Encuestas</option>
                            <option value="otros" {{ old('tipo_metrica') == 'otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        @error('tipo_metrica')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}" 
                               required
                               placeholder="Ej: Intención de voto en jóvenes">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="valor" class="form-label">Valor *</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control @error('valor') is-invalid @enderror" 
                                   id="valor" 
                                   name="valor" 
                                   value="{{ old('valor') }}" 
                                   required
                                   placeholder="0.00">
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="unidad" class="form-label">Unidad</label>
                            <input type="text" 
                                   class="form-control @error('unidad') is-invalid @enderror" 
                                   id="unidad" 
                                   name="unidad" 
                                   value="{{ old('unidad') }}"
                                   placeholder="Ej: %, puntos, personas">
                            <div class="form-text">Dejar vacío si no aplica</div>
                            @error('unidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_medicion" class="form-label">Fecha de Medición *</label>
                        <input type="date" 
                               class="form-control @error('fecha_medicion') is-invalid @enderror" 
                               id="fecha_medicion" 
                               name="fecha_medicion" 
                               value="{{ old('fecha_medicion', date('Y-m-d')) }}" 
                               required>
                        @error('fecha_medicion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="metadata" class="form-label">Metadatos (JSON)</label>
                        <textarea class="form-control @error('metadata') is-invalid @enderror" 
                                  id="metadata" 
                                  name="metadata" 
                                  rows="3"
                                  placeholder='{"fuente": "Encuesta X", "tamano_muestra": 1000, "margen_error": 3}'></textarea>
                        <div class="form-text">Información adicional en formato JSON (opcional)</div>
                        @error('metadata')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Métrica</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress-tendencia {
        height: 8px;
        margin-top: 5px;
    }
    
    .valor-destacado {
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>
@endpush


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración del gráfico
    const ctx = document.getElementById('metricasChart').getContext('2d');
    
    // Preparar datos para el gráfico
    const tiposMetricas = @json($tiposMetricas);
    const metricasPorTipo = {};
    
    @foreach($tiposMetricas as $tipo)
        metricasPorTipo['{{ $tipo }}'] = @json($metricas->where('tipo_metrica', $tipo)->take(10)->values());
    @endforeach
    
    // Colores para los tipos de métricas
    const colores = {
        'intencion_voto': '#007bff',
        'reconocimiento': '#28a745',
        'popularidad': '#ffc107',
        'redes_sociales': '#dc3545',
        'eventos': '#6f42c1',
        'donaciones': '#20c997',
        'voluntarios': '#fd7e14',
        'encuestas': '#17a2b8',
        'otros': '#6c757d'
    };
    
    // Crear datasets para el gráfico
    const datasets = [];
    
    tiposMetricas.forEach(tipo => {
        const datosTipo = metricasPorTipo[tipo];
        if (datosTipo && datosTipo.length > 0) {
            datasets.push({
                label: tipo.charAt(0).toUpperCase() + tipo.slice(1).replace('_', ' '),
                data: datosTipo.map(m => ({
                    x: m.fecha_medicion,
                    y: m.valor
                })),
                borderColor: colores[tipo] || '#6c757d',
                backgroundColor: colores[tipo] ? colores[tipo] + '20' : '#6c757d20',
                borderWidth: 2,
                tension: 0.1,
                fill: false
            });
        }
    });
    
    // Crear el gráfico
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM d'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Valor'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            
                            // Agregar unidad si está disponible
                            const metrica = context.raw.metrica;
                            if (metrica && metrica.unidad) {
                                label += ' ' + metrica.unidad;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
    
    // Botón exportar gráfico
    document.getElementById('exportChart').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'grafico_metricas_' + new Date().toISOString().split('T')[0] + '.png';
        link.href = chart.toBase64Image();
        link.click();
    });
    
    // Botón exportar Excel
    document.getElementById('exportExcel').addEventListener('click', function() {
        exportarExcel('metricas-table', 'metricas_' + '{{ $candidato->alias }}');
    });
    
    // Botón exportar PDF
    document.getElementById('exportPdf').addEventListener('click', function() {
        exportarPDF('metricas-table', 'Reporte de Métricas - {{ $candidato->nombre_completo }}', 'metricas_{{ $candidato->alias }}');
    });
    
    // Función para exportar a Excel
    function exportarExcel(tablaId, nombreArchivo) {
        const tabla = document.getElementById(tablaId);
        if (!tabla) {
            Swal.fire('Error', 'No se encontró la tabla de datos', 'error');
            return;
        }
        
        // Verificar si XLSX está disponible
        if (typeof XLSX === 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Función no disponible',
                text: 'La función de exportar a Excel requiere la biblioteca SheetJS',
                footer: '<a href="https://sheetjs.com/" target="_blank">Más información</a>'
            });
            return;
        }
        
        // Crear libro de trabajo
        const wb = XLSX.utils.book_new();
        
        // Crear hoja de trabajo a partir de la tabla
        const ws = XLSX.utils.table_to_sheet(tabla);
        
        // Ajustar ancho de columnas
        const wscols = [
            { wch: 15 }, // Fecha
            { wch: 15 }, // Tipo
            { wch: 25 }, // Nombre
            { wch: 12 }, // Valor
            { wch: 10 }, // Unidad
            { wch: 12 }, // Tendencia
            { wch: 15 }  // Acciones
        ];
        ws['!cols'] = wscols;
        
        // Agregar hoja al libro
        XLSX.utils.book_append_sheet(wb, ws, 'Métricas');
        
        // Descargar archivo
        XLSX.writeFile(wb, `${nombreArchivo}_${new Date().toISOString().split('T')[0]}.xlsx`);
        
        Swal.fire({
            icon: 'success',
            title: '¡Exportado!',
            text: 'El archivo Excel se está descargando',
            timer: 2000,
            showConfirmButton: false
        });
    }
    
    // Función para exportar a PDF
    function exportarPDF(tablaId, titulo, nombreArchivo) {
        const tabla = document.getElementById(tablaId);
        if (!tabla) {
            Swal.fire('Error', 'No se encontró la tabla de datos', 'error');
            return;
        }
        
        // Verificar si jsPDF está disponible
        if (typeof jsPDF === 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Función no disponible',
                text: 'La función de exportar a PDF requiere la biblioteca jsPDF',
                footer: '<a href="https://raw.githack.com/MrRio/jsPDF/master/" target="_blank">Más información</a>'
            });
            return;
        }
        
        // Verificar si html2canvas está disponible
        if (typeof html2canvas === 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Función no disponible',
                text: 'La función de exportar a PDF requiere la biblioteca html2canvas',
                footer: '<a href="https://html2canvas.hertzen.com/" target="_blank">Más información</a>'
            });
            return;
        }
        
        Swal.fire({
            title: 'Generando PDF...',
            text: 'Por favor espere un momento',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Crear PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');
        
        // Agregar título
        doc.setFontSize(18);
        doc.text(titulo, 14, 22);
        
        // Agregar fecha
        doc.setFontSize(10);
        doc.text(`Generado: ${new Date().toLocaleDateString('es-ES')}`, 14, 30);
        
        // Convertir tabla a imagen
        html2canvas(tabla, {
            scale: 2,
            useCORS: true,
            logging: false
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 280;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            
            // Agregar imagen al PDF
            doc.addImage(imgData, 'PNG', 10, 40, imgWidth, imgHeight);
            
            // Descargar PDF
            doc.save(`${nombreArchivo}_${new Date().toISOString().split('T')[0]}.pdf`);
            
            Swal.close();
            
            Swal.fire({
                icon: 'success',
                title: '¡PDF Generado!',
                text: 'El archivo PDF se ha descargado correctamente',
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo generar el PDF: ' + error.message
            });
        });
    }
    
    // Validar JSON en metadatos
    const metadataTextarea = document.getElementById('metadata');
    if (metadataTextarea) {
        metadataTextarea.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value) {
                try {
                    JSON.parse(value);
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } catch (e) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'JSON Inválido',
                        text: 'Los metadatos deben estar en formato JSON válido'
                    });
                }
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });
    }
    
    // Filtrar métricas en tiempo real
    const tipoMetricaSelect = document.getElementById('tipo_metrica');
    if (tipoMetricaSelect) {
        tipoMetricaSelect.addEventListener('change', function() {
            if (this.value) {
                // Aquí se podría implementar filtrado AJAX
                console.log('Filtrando por tipo:', this.value);
            }
        });
    }
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>