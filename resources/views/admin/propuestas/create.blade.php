<!-- resources/views/admin/propuestas/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Crear Propuesta')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Crear Nueva Propuesta</h5>
                <p class="mb-0 text-muted">
                    Candidato: 
                    <a href="{{ route('candidatos.show', $candidato) }}" class="text-decoration-none">
                        {{ $candidato->nombre_completo }}
                    </a>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('candidatos.propuestas.store', $candidato) }}" method="POST">
                    @csrf
                    
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
                                                   value="{{ old('titulo') }}" 
                                                   required
                                                   placeholder="Ej: SEGURIDAD INTEGRAL">
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
                                                      required
                                                      placeholder="Describa la propuesta en detalle...">{{ old('descripcion') }}</textarea>
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
                                                    <option value="{{ $valor }}" {{ old('categoria') == $valor ? 'selected' : '' }}>
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
                                                    <option value="{{ $valor }}" {{ old('icono') == $valor ? 'selected' : '' }}>
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
                                                       value="{{ old('color', '#007bff') }}"
                                                       title="Seleccionar color"
                                                       required>
                                                <input type="text" 
                                                       class="form-control @error('color') is-invalid @enderror" 
                                                       value="{{ old('color', '#007bff') }}"
                                                       readonly>
                                            </div>
                                            <div class="form-text">
                                                Color que representará esta propuesta en gráficas y tarjetas.
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
                                                   value="{{ old('orden') }}"
                                                   min="1">
                                            <div class="form-text">
                                                Dejar vacío para colocar al final.
                                            </div>
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
                                                       {{ old('destacada') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="destacada">
                                                    Propuesta destacada
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                Las propuestas destacadas aparecerán resaltadas.
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
                                    <h6 class="mb-0">Metas e Indicadores (Opcional)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Metas</label>
                                            <div id="metas-container">
                                                @if(old('metas'))
                                                    @foreach(old('metas') as $index => $meta)
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
                                                @if(old('indicadores'))
                                                    @foreach(old('indicadores') as $index => $indicador)
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
                        
                        <!-- Vista Previa -->
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Vista Previa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="card propuesta-card mb-0" id="preview-card" 
                                         style="border-left-color: {{ old('color', '#007bff') }};">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar avatar-md me-3" id="preview-icon">
                                                    <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center"
                                                         style="background-color: {{ old('color', '#007bff') }}20; color: {{ old('color', '#007bff') }};">
                                                        <i class="{{ old('icono', 'fas fa-bullhorn') }} fs-4"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 id="preview-titulo" class="mb-1">
                                                        {{ old('titulo', 'Título de la propuesta') }}
                                                    </h5>
                                                    <span class="badge" id="preview-categoria"
                                                          style="background-color: {{ old('color', '#007bff') }}20; color: {{ old('color', '#007bff') }};">
                                                        {{ old('categoria') ? ucfirst(str_replace('_', ' ', old('categoria'))) : 'Categoría' }}
                                                    </span>
                                                    @if(old('destacada'))
                                                        <span class="badge bg-warning ms-1" id="preview-destacada">Destacada</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="card-text text-muted mt-3" id="preview-descripcion">
                                                {{ old('descripcion', 'Descripción de la propuesta aparecerá aquí...') }}
                                            </p>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar Propuesta
                                </button>
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
        updatePreviewColor(this.value);
    });
    
    colorText.addEventListener('input', function() {
        colorPicker.value = this.value;
        updatePreviewColor(this.value);
    });
    
    // Actualizar vista previa en tiempo real
    document.getElementById('titulo').addEventListener('input', function() {
        document.getElementById('preview-titulo').textContent = this.value || 'Título de la propuesta';
    });
    
    document.getElementById('descripcion').addEventListener('input', function() {
        document.getElementById('preview-descripcion').textContent = this.value || 'Descripción de la propuesta aparecerá aquí...';
    });
    
    document.getElementById('categoria').addEventListener('change', function() {
        const categoriaTexto = this.options[this.selectedIndex].text;
        document.getElementById('preview-categoria').textContent = categoriaTexto;
    });
    
    document.getElementById('icono').addEventListener('change', function() {
        const icono = this.value;
        document.querySelector('#preview-icon i').className = icono + ' fs-4';
    });
    
    document.getElementById('destacada').addEventListener('change', function() {
        const previewDestacada = document.getElementById('preview-destacada');
        if (this.checked) {
            if (!previewDestacada) {
                const badge = document.createElement('span');
                badge.className = 'badge bg-warning ms-1';
                badge.id = 'preview-destacada';
                badge.textContent = 'Destacada';
                document.getElementById('preview-categoria').parentNode.appendChild(badge);
            }
        } else {
            if (previewDestacada) {
                previewDestacada.remove();
            }
        }
    });
    
    function updatePreviewColor(color) {
        // Actualizar color del borde
        document.getElementById('preview-card').style.borderLeftColor = color;
        
        // Actualizar color del icono
        const previewIcon = document.querySelector('#preview-icon .avatar-name');
        previewIcon.style.backgroundColor = color + '20';
        previewIcon.style.color = color;
        
        // Actualizar color de la categoría
        const categoriaBadge = document.getElementById('preview-categoria');
        categoriaBadge.style.backgroundColor = color + '20';
        categoriaBadge.style.color = color;
    }
    
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
        
        // Mostrar botón eliminar en todos menos el último
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
        
        // Mostrar botón eliminar en todos menos el último
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