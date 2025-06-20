@extends('layouts.admin')
@section('title', 'Editar Campaña')
@section('styles')
<link href="{{ asset('falcon/css/dropzone.min.css') }}" rel="stylesheet">
<style>
    .invalid-feedback {
        display: block !important;
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .current-image-container {
        text-align: center;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Editar Campaña: {{ $campaña->name }}</h5>
            </div>
            <div class="col-auto">
                <a href="{{ route('campañas.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Regresar
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        {!! Form::model($campaña, ['route' => ['campañas.update', $campaña], 'method' => 'PUT', 'files' => true]) !!}

        <div class="row g-3">
            <!-- Nombre -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nombre de la campaña" 
                           value="{{ old('name', $campaña->name) }}" required>
                    <label for="name">Nombre</label>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Estado -->
            <div class="col-md-6">
                <div class="form-floating">
                    <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="activo" {{ $campaña->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $campaña->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    <label for="estado">Estado</label>
                    @error('estado')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Tipo -->
            <div class="col-md-6">
                <div class="form-floating">
                    <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                        <option value="publica" {{ $campaña->tipo == 'publica' ? 'selected' : '' }}>Pública</option>
                        <option value="privada" {{ $campaña->tipo == 'privada' ? 'selected' : '' }}>Privada</option>
                    </select>
                    <label for="tipo">Tipo de Campaña</label>
                    @error('tipo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Fechas -->
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                           value="{{ old('fecha_inicio', $campaña->fecha_inicio) }}">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    @error('fecha_inicio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-floating">
                    <input type="date" name="fecha_fin" id="fecha_fin" 
                           class="form-control @error('fecha_fin') is-invalid @enderror"
                           value="{{ old('fecha_fin', $campaña->fecha_fin) }}">
                    <label for="fecha_fin">Fecha de Fin</label>
                    @error('fecha_fin')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-12">
                <div class="form-floating">
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                              placeholder="Descripción de la campaña" 
                              name="description" style="height: 100px">{{ old('description', $campaña->description) }}</textarea>
                    <label for="description">Descripción</label>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Imagen -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Imagen de la Campaña</h5>
                    </div>
                    <div class="card-body">
                        @if($campaña->image)
                        <div class="current-image-container">
                            <p class="text-muted">Imagen actual:</p>
                            <img src="{{ asset('image/'.$campaña->image) }}" class="image-preview">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image">
                                <label class="form-check-label" for="remove_image">
                                    Eliminar imagen actual
                                </label>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Nueva imagen (opcional)</label>
                            <input type="file" name="image" id="image" 
                                   class="form-control @error('image') is-invalid @enderror">
                            <small class="text-muted">Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('campañas.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de fechas
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');
    
    if(fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', function() {
            if(fechaFin.value && this.value > fechaFin.value) {
                alert('La fecha de inicio no puede ser mayor a la fecha de fin');
                this.value = '';
            }
        });
        
        fechaFin.addEventListener('change', function() {
            if(fechaInicio.value && this.value < fechaInicio.value) {
                alert('La fecha de fin no puede ser menor a la fecha de inicio');
                this.value = '';
            }
        });
    }

    // Preview de nueva imagen
    const imageInput = document.getElementById('image');
    if(imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewContainer = document.querySelector('.current-image-container');
                    if(previewContainer) {
                        previewContainer.innerHTML = `
                            <p class="text-muted">Nueva imagen:</p>
                            <img src="${event.target.result}" class="image-preview">
                        `;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection