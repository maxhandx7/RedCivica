@extends('layouts.admin')
@section('title', 'Nueva Campaña')
@section('styles')
<link href="{{ asset('/falcon/public/vendors/dropzone/dropzone.css') }}" rel="stylesheet">
<style>
    .invalid-feedback {
        display: block !important;
    }
    .dropzone {
        border: 2px dashed #dee2e6;
        border-radius: 6px;
        background: #f8f9fa;
    }
    .dropzone .dz-message {
        margin: 3rem 0;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Nueva Campaña</h5>
            </div>
            <div class="col-auto">
                <a href="{{ route('campañas.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Regresar
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => 'campañas.store', 'method' => 'POST', 'files' => true]) !!}

        <div class="row g-3">
            <!-- Nombre -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nombre de la campaña" required>
                    <label for="name">Nombre</label>
                    @error('name')
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
                        <option value="publica" selected>Pública</option>
                        <option value="privada">Privada</option>
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
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           class="form-control @error('fecha_inicio') is-invalid @enderror">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    @error('fecha_inicio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" name="fecha_fin" id="fecha_fin" 
                           class="form-control @error('fecha_fin') is-invalid @enderror">
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
                              placeholder="Descripción de la campaña" name="description" style="height: 100px"></textarea>
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

            <!-- Botones -->
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Campaña
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
{!! Html::script('/falcon/public/vendors/dropzone/dropzone-min.js') !!}
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
});
</script>
@endsection 