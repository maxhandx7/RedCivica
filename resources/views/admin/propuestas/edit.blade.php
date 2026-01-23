@extends('layouts.admin')

@section('title', 'Editar Propuesta')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Editar Propuesta</h5>
                <p class="mb-0 text-muted">
                    Candidato: 
                    <a href="{{ route('candidatos.show', $candidato) }}" class="text-decoration-none">
                        {{ $candidato->nombre_completo }}
                    </a>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('candidatos.propuestas.update', [$candidato, $propuesta]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-md-8 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información de la Propuesta</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="titulo" class="form-label">Título *</label>
                                            <input type="text" 
                                                   class="form-control @error('titulo') is-invalid @enderror" 
                                                   id="titulo" 
                                                   name="titulo" 
                                                   value="{{ old('titulo', $propuesta->titulo) }}" 
                                                   required>
                                            @error('titulo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="descripcion" class="form-label">Descripción *</label>
                                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                      id="descripcion" 
                                                      name="descripcion" 
                                                      rows="6" 
                                                      required>{{ old('descripcion', $propuesta->descripcion) }}</textarea>
                                            @error('descripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="categoria" class="form-label">Categoría *</label>
                                            <select class="form-select @error('categoria') is-invalid @enderror" 
                                                    id="categoria" 
                                                    name="categoria" 
                                                    required>
                                                <option value="">Seleccionar categoría...</option>
                                                @foreach($categorias as $valor => $texto)
                                                    <option value="{{ $valor }}" {{ old('categoria', $propuesta->categoria) == $valor ? 'selected' : '' }}>
                                                        {{ $texto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('categoria')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="icono" class="form-label">Icono *</label>
                                            <select class="form-select @error('icono') is-invalid @enderror" 
                                                    id="icono" 
                                                    name="icono" 
                                                    required>
                                                <option value="">Seleccionar icono...</option>
                                                @foreach($iconos as $valor => $texto)
                                                    <option value="{{ $valor }}" {{ old('icono', $propuesta->icono) == $valor ? 'selected' : '' }}>
                                                        <i class="{{ $valor }} me-2"></i> {{ $texto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('icono')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Configuración -->
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="color" class="form-label">Color *</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                       class="form-control form-control-color @error('color') is-invalid @enderror" 
                                                       id="color" 
                                                       name="color" 
                                                       value="{{ old('color', $propuesta->color) }}"
                                                       title="Seleccionar color"
                                                       required>
                                                <input type="text" 
                                                       class="form-control @error('color') is-invalid @enderror" 
                                                       value="{{ old('color', $propuesta->color) }}"
                                                       readonly>
                                            </div>
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="orden" class="form-label">Orden</label>
                                            <input type="number" 
                                                   class="form-control @error('orden') is-invalid @enderror" 
                                                   id="orden" 
                                                   name="orden" 
                                                   value="{{ old('orden', $propuesta->orden) }}"
                                                   min="1">
                                            @error('orden')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="destacada" 
                                                       name="destacada" 
                                                       value="1" 
                                                       {{ old('destacada', $propuesta->destacada) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="destacada">
                                                    Propuesta destacada
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Metas e Indicadores -->
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Metas e Indicadores</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Metas</label>
                                            <div id="metas-container">
                                                @php
                                                    $metas = old('metas', $propuesta->metas ?? []);
                                                @endphp
                                                
                                                @if(count($metas) > 0)
                                                    @foreach($metas as $meta)
                                                        <div class="input-group mb-2 meta-item">
                                                            <input type="text" 
                                                                   name="metas[]" 
                                                                   class="form-control" 
                                                                   value="{{ $meta }}"
                                                                   placeholder="Ej: Reducir delitos en un 30%">
                                                            <button type="button" class="btn btn-outline-danger remove-meta">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2 meta-item">
                                                        <input type="text" 
                                                               name="metas[]" 
                                                               class="form-control" 
                                                               placeholder="Ej: Reducir delitos en un 30%">
                                                        <button type="button" class="btn btn-outline-danger remove-meta">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="add-meta" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus me-1"></i> Agregar Meta
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Indicadores</label>
                                            <div id="indicadores-container">
                                                @php
                                                    $indicadores = old('indicadores', $propuesta->indicadores ?? []);
                                                @endphp
                                                
                                                @if(count($indicadores) > 0)
                                                    @foreach($indicadores as $indicador)
                                                        <div class="input-group mb-2 indicador-item">
                                                            <input type="text" 
                                                                   name="indicadores[]" 
                                                                   class="form-control" 
                                                                   value="{{ $indicador }}"
                                                                   placeholder="Ej: Tasa de criminalidad">
                                                            <button type="button" class="btn btn-outline-danger remove-indicador">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="input-group mb-2 indicador-item">
                                                        <input type="text" 
                                                               name="indicadores[]" 
                                                               class="form-control" 
                                                               placeholder="Ej: Tasa de criminalidad">
                                                        <button type="button" class="btn btn-outline-danger remove-indicador">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="add-indicador" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus me-1"></i> Agregar Indicador
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('candidatos.propuestas.index', $candidato) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                                </a>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Guardar Cambios
                                    </button>
                                    <a href="{{ route('candidatos.propuestas.index', $candidato) }}" class="btn btn-outline-secondary">
                                        Ver todas las propuestas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .meta-item:last-child .remove-meta,
    .indicador-item:last-child .remove-indicador {
        display: none;
    }
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sincronizar color picker
    const colorPicker = document.getElementById('color');
    const colorText = document.querySelector('input[name="color"] + .form-control');
    
    colorPicker.addEventListener('input', function() {
        colorText.value = this.value;
    });
    
    colorText.addEventListener('input', function() {
        colorPicker.value = this.value;
    });
    
    // Manejo de metas dinámicas
    document.getElementById('add-meta').addEventListener('click', function() {
        const container = document.getElementById('metas-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 meta-item';
        div.innerHTML = `
            <input type="text" name="metas[]" class="form-control" placeholder="Ej: Reducir delitos en un 30%">
            <button type="button" class="btn btn-outline-danger remove-meta">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(div);
        updateMetaButtons();
    });
    
    // Manejo de indicadores dinámicos
    document.getElementById('add-indicador').addEventListener('click', function() {
        const container = document.getElementById('indicadores-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 indicador-item';
        div.innerHTML = `
            <input type="text" name="indicadores[]" class="form-control" placeholder="Ej: Tasa de criminalidad">
            <button type="button" class="btn btn-outline-danger remove-indicador">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(div);
        updateIndicadorButtons();
    });
    
    // Delegar eventos para botones eliminar
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-meta') || e.target.closest('.remove-meta')) {
            const button = e.target.classList.contains('remove-meta') ? e.target : e.target.closest('.remove-meta');
            button.closest('.meta-item').remove();
            updateMetaButtons();
        }
        
        if (e.target.classList.contains('remove-indicador') || e.target.closest('.remove-indicador')) {
            const button = e.target.classList.contains('remove-indicador') ? e.target : e.target.closest('.remove-indicador');
            button.closest('.indicador-item').remove();
            updateIndicadorButtons();
        }
    });
    
    function updateMetaButtons() {
        const items = document.querySelectorAll('.meta-item');
        items.forEach((item, index) => {
            const button = item.querySelector('.remove-meta');
            button.style.display = items.length > 1 ? 'block' : 'none';
        });
    }
    
    function updateIndicadorButtons() {
        const items = document.querySelectorAll('.indicador-item');
        items.forEach((item, index) => {
            const button = item.querySelector('.remove-indicador');
            button.style.display = items.length > 1 ? 'block' : 'none';
        });
    }
    
    // Inicializar botones
    updateMetaButtons();
    updateIndicadorButtons();
});
</script>
