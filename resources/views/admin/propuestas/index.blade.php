<!-- resources/views/admin/propuestas/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Propuestas de ' . $candidato->nombre_completo)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 fw-bold mb-1">Propuestas</h2>
                <p class="text-muted mb-0">
                    Candidato: 
                    <a href="{{ route('candidatos.show', $candidato) }}" class="text-decoration-none">
                        {{ $candidato->nombre_completo }}
                    </a>
                </p>
            </div>
            <div class="btn-group">
                <a href="{{ route('candidatos.show', $candidato) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Candidato
                </a>
                <a href="{{ route('candidatos.propuestas.create', $candidato) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Nueva Propuesta
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('candidatos.propuestas.index', $candidato) }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $valor => $texto)
                                <option value="{{ $valor }}" {{ request('categoria') == $valor ? 'selected' : '' }}>
                                    {{ $texto }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="destacada" class="form-label">Destacada</label>
                        <select name="destacada" id="destacada" class="form-select">
                            <option value="">Todas</option>
                            <option value="1" {{ request('destacada') == '1' ? 'selected' : '' }}>Solo destacadas</option>
                            <option value="0" {{ request('destacada') == '0' ? 'selected' : '' }}>No destacadas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="busqueda" class="form-label">Buscar</label>
                        <div class="input-group">
                            <input type="text" 
                                   name="busqueda" 
                                   id="busqueda" 
                                   class="form-control" 
                                   value="{{ request('busqueda') }}" 
                                   placeholder="Buscar en título o descripción...">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #007bff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Total</h6>
                        <h3 class="mb-0">{{ $propuestas->count() }}</h3>
                    </div>
                    <i class="fas fa-bullhorn fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Destacadas</h6>
                        <h3 class="mb-0">{{ $propuestas->where('destacada', true)->count() }}</h3>
                    </div>
                    <i class="fas fa-star fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Categorías</h6>
                        <h3 class="mb-0">{{ $propuestas->pluck('categoria')->unique()->count() }}</h3>
                    </div>
                    <i class="fas fa-tags fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="border-left: 4px solid #6f42c1;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Última</h6>
                        <h6 class="mb-0" style="font-size: 1rem;">
                            {{ $propuestas->last() ? $propuestas->last()->created_at->diffForHumans() : 'N/A' }}
                        </h6>
                    </div>
                    <i class="fas fa-clock fa-2x text-purple"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Propuestas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($propuestas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50px">Orden</th>
                                    <th width="60px">Icono</th>
                                    <th>Propuesta</th>
                                    <th>Categoría</th>
                                    <th>Color</th>
                                    <th>Destacada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="propuestas-list">
                                @foreach($propuestas as $propuesta)
                                <tr data-id="{{ $propuesta->id }}" 
                                    style="border-left: 4px solid {{ $propuesta->color }};">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-grip-vertical drag-handle me-2 text-muted"></i>
                                            <span class="badge bg-secondary">{{ $propuesta->orden }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar avatar-sm">
                                            <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center"
                                                 style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                                <i class="{{ $propuesta->icono }}"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $propuesta->titulo }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($propuesta->descripcion, 100) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge" 
                                              style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                            {{ $propuesta->categoria_formateada }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" 
                                                 style="width: 20px; height: 20px; background-color: {{ $propuesta->color }}; border-radius: 4px;"></div>
                                            <span>{{ $propuesta->color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('candidatos.propuestas.toggle-destacada', [$candidato, $propuesta]) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @if($propuesta->destacada)
                                                <button type="submit" class="badge bg-warning border-0">
                                                    <i class="fas fa-star me-1"></i> Sí
                                                </button>
                                            @else
                                                <button type="submit" class="badge bg-secondary border-0">
                                                    <i class="far fa-star me-1"></i> No
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" 
                                               class="btn btn-outline-info" 
                                               title="Vista previa"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#previewModal{{ $propuesta->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('candidatos.propuestas.edit', [$candidato, $propuesta]) }}" 
                                               class="btn btn-outline-secondary" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('candidatos.propuestas.destroy', [$candidato, $propuesta]) }}" 
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
                                        
                                        <!-- Modal de Vista Previa -->
                                        <div class="modal fade" id="previewModal{{ $propuesta->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="border-left: 4px solid {{ $propuesta->color }};">
                                                        <h5 class="modal-title">
                                                            <i class="{{ $propuesta->icono }} me-2" style="color: {{ $propuesta->color }};"></i>
                                                            {{ $propuesta->titulo }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <span class="badge" 
                                                                  style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                                                {{ $propuesta->categoria_formateada }}
                                                            </span>
                                                            @if($propuesta->destacada)
                                                                <span class="badge bg-warning ms-1">Destacada</span>
                                                            @endif
                                                            <span class="badge bg-secondary ms-1">Orden: {{ $propuesta->orden }}</span>
                                                        </div>
                                                        
                                                        <h6>Descripción:</h6>
                                                        <p class="text-muted">{{ $propuesta->descripcion }}</p>
                                                        
                                                        @if($propuesta->metas)
                                                            <h6 class="mt-4">Metas:</h6>
                                                            <ul class="list-group list-group-flush">
                                                                @foreach($propuesta->metas as $meta)
                                                                    <li class="list-group-item">{{ $meta }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <a href="{{ route('candidatos.propuestas.edit', [$candidato, $propuesta]) }}" 
                                                           class="btn btn-primary">
                                                            <i class="fas fa-edit me-2"></i> Editar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No hay propuestas registradas para este candidato</p>
                        <a href="{{ route('candidatos.propuestas.create', $candidato) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Crear Primera Propuesta
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar drag and drop para reordenamiento
        inicializarSortable('#propuestas-list', '{{ route("candidatos.propuestas.reordenar", $candidato) }}');
    });
</script>