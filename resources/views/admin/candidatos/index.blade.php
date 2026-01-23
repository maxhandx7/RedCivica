<!-- resources/views/admin/candidatos/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Candidatos')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 fw-bold mb-1">Candidatos</h2>
                <p class="text-muted mb-0">Gestión de todos los candidatos registrados</p>
            </div>
            <a href="{{ route('candidatos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nuevo Candidato
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('candidatos.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <select name="cargo" id="cargo" class="form-select">
                            <option value="">Todos los cargos</option>
                            <option value="senador" {{ request('cargo') == 'senador' ? 'selected' : '' }}>Senador</option>
                            <option value="representante" {{ request('cargo') == 'representante' ? 'selected' : '' }}>Representante</option>
                            <option value="presidente" {{ request('cargo') == 'presidente' ? 'selected' : '' }}>Presidente</option>
                            <option value="gobernador" {{ request('cargo') == 'gobernador' ? 'selected' : '' }}>Gobernador</option>
                            <option value="alcalde" {{ request('cargo') == 'alcalde' ? 'selected' : '' }}>Alcalde</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="partido" class="form-label">Partido</label>
                        <input type="text" name="partido" id="partido" class="form-control" 
                               value="{{ request('partido') }}" placeholder="Filtrar por partido">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="activo" id="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('candidatos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Candidatos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($candidatos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="60px">Orden</th>
                                    <th width="70px">Imagen</th>
                                    <th>Candidato</th>
                                    <th>Cargo</th>
                                    <th>Partido</th>
                                    <th>Propuestas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="candidatos-list">
                                @foreach($candidatos as $candidato)
                                <tr data-id="{{ $candidato->id }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-grip-vertical drag-handle me-2 text-muted"></i>
                                            <span class="badge bg-secondary">{{ $candidato->orden }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($candidato->imagen)
                                            <img src="{{ Storage::url($candidato->imagen) }}" 
                                                 class="rounded-circle" 
                                                 width="50" 
                                                 height="50" 
                                                 alt="{{ $candidato->nombre_completo }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; background-color: {{ $candidato->color_principal }}20; border: 2px solid {{ $candidato->color_principal }};">
                                                <span class="fw-bold" style="color: {{ $candidato->color_principal }};">
                                                    {{ $candidato->iniciales }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $candidato->nombre_completo }}</strong><br>
                                        <small class="text-muted">{{ $candidato->alias }}</small><br>
                                        <small class="text-muted">{{ $candidato->circunscripcion }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($candidato->cargo) }}</span>
                                    </td>
                                    <td>{{ $candidato->partido }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $candidato->propuestas_count }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('candidatos.toggle-activo', $candidato) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @if($candidato->activo)
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
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('candidatos.show', $candidato) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('candidatos.propuestas.index', $candidato) }}" 
                                               class="btn btn-outline-info" 
                                               title="Propuestas">
                                                <i class="fas fa-bullhorn"></i>
                                            </a>
                                            <a href="{{ route('candidatos.edit', $candidato) }}" 
                                               class="btn btn-outline-secondary" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('candidatos.destroy', $candidato) }}" 
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
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    @if($candidatos->hasPages())
                    <div class="mt-3">
                        {{ $candidatos->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-tie fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No hay candidatos registrados</p>
                        <a href="{{ route('candidatos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Crear Primer Candidato
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let el = document.getElementById('candidatos-list');
        let sortable = Sortable.create(el, {
            animation: 150,
            onEnd: function(evt) {
                // Aquí iría tu lógica para guardar el orden
                console.log('Se movió del índice ' + evt.oldIndex + ' al ' + evt.newIndex);
            }
        });
    });
</script>
