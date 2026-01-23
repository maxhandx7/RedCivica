<!-- resources/views/admin/tarjetones/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Tarjetones Electorales')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 fw-bold mb-1">Tarjetones Electorales</h2>
                <p class="text-muted mb-0">Gestión de todos los tarjetones registrados</p>
            </div>
            <a href="{{ route('tarjetones.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nuevo Tarjetón
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tarjetones.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="candidato_id" class="form-label">Candidato</label>
                        <select name="candidato_id" id="candidato_id" class="form-select">
                            <option value="">Todos los candidatos</option>
                            @foreach($candidatos ?? [] as $candidato)
                                <option value="{{ $candidato->id }}" {{ request('candidato_id') == $candidato->id ? 'selected' : '' }}>
                                    {{ $candidato->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="activo" class="form-label">Estado</label>
                        <select name="activo" id="activo" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('tarjetones.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Tarjetones -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($tarjetones->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Candidato</th>
                                    <th>Opciones</th>
                                    <th>Secciones</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tarjetones as $tarjeton)
                                <tr>
                                    <td>
                                        <strong>{{ $tarjeton->nombre }}</strong>
                                        @if($tarjeton->instruccion)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($tarjeton->instruccion, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tarjeton->candidato)
                                            <div class="d-flex align-items-center">
                                                @if($tarjeton->candidato->imagen)
                                                    <img src="{{ Storage::url($tarjeton->candidato->imagen) }}" 
                                                         class="rounded-circle me-2" 
                                                         width="30" 
                                                         height="30" 
                                                         alt="{{ $tarjeton->candidato->nombre_completo }}">
                                                @else
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                         style="width: 30px; height: 30px; background-color: {{ $tarjeton->candidato->color_principal }}20;">
                                                        <span class="fw-bold" style="font-size: 0.8rem; color: {{ $tarjeton->candidato->color_principal }};">
                                                            {{ $tarjeton->candidato->iniciales }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div>{{ $tarjeton->candidato->nombre_completo }}</div>
                                                    <small class="text-muted">{{ $tarjeton->candidato->cargo_formateado }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Sin candidato</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $tarjeton->total_opciones }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ count($tarjeton->secciones) }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('tarjetones.toggle-activo', $tarjeton) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @if($tarjeton->activo)
                                                <button type="submit" class="badge bg-success border-0">
                                                    <i class="fas fa-check me-1"></i> Activo
                                                </button>
                                            @else
                                                <button type="submit" class="badge bg-danger border-0">
                                                    <i class="fas fa-times me-1"></i> Inactivo
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $tarjeton->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('tarjetones.show', $tarjeton) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <a href="{{ route('tarjetones.preview', $tarjeton) }}" 
                                               class="btn btn-outline-info" 
                                               title="Vista Previa"
                                               target="_blank">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            
                                            <a href="{{ route('tarjetones.edit', $tarjeton) }}" 
                                               class="btn btn-outline-secondary" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-outline-warning dropdown-toggle dropdown-toggle-split" 
                                                    data-bs-toggle="dropdown" 
                                                    title="Más opciones">
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('tarjetones.export-pdf', $tarjeton) }}">
                                                        <i class="fas fa-file-pdf me-2"></i> Exportar PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('tarjetones.export-image', $tarjeton) }}">
                                                        <i class="fas fa-image me-2"></i> Exportar Imagen
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('tarjetones.duplicate', $tarjeton) }}">
                                                        <i class="fas fa-copy me-2"></i> Duplicar
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('tarjetones.destroy', $tarjeton) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                onclick="confirmarEliminacion(event)" 
                                                                class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    @if($tarjetones->hasPages())
                    <div class="mt-3">
                        {{ $tarjetones->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No hay tarjetones registrados</p>
                        <a href="{{ route('tarjetones.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Crear Primer Tarjetón
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection