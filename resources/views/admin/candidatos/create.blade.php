<!-- resources/views/admin/candidatos/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Crear Candidato')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Crear Nuevo Candidato</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('candidatos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Básica</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">Nombre *</label>
                                            <input type="text" 
                                                   class="form-control @error('nombre') is-invalid @enderror" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   value="{{ old('nombre') }}" 
                                                   required>
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="apellido" class="form-label">Apellido *</label>
                                            <input type="text" 
                                                   class="form-control @error('apellido') is-invalid @enderror" 
                                                   id="apellido" 
                                                   name="apellido" 
                                                   value="{{ old('apellido') }}" 
                                                   required>
                                            @error('apellido')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="alias" class="form-label">Alias/Nombre Corto</label>
                                            <input type="text" 
                                                   class="form-control @error('alias') is-invalid @enderror" 
                                                   id="alias" 
                                                   name="alias" 
                                                   value="{{ old('alias') }}">
                                            @error('alias')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="cargo" class="form-label">Cargo *</label>
                                            <select class="form-select @error('cargo') is-invalid @enderror" 
                                                    id="cargo" 
                                                    name="cargo" 
                                                    required>
                                                <option value="">Seleccionar cargo...</option>
                                                @foreach($cargos as $valor => $texto)
                                                    <option value="{{ $valor }}" {{ old('cargo') == $valor ? 'selected' : '' }}>
                                                        {{ $texto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cargo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="partido" class="form-label">Partido/Coalición *</label>
                                            <input type="text" 
                                                   class="form-control @error('partido') is-invalid @enderror" 
                                                   id="partido" 
                                                   name="partido" 
                                                   value="{{ old('partido') }}" 
                                                   required>
                                            @error('partido')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="lema" class="form-label">Lema de Campaña</label>
                                            <input type="text" 
                                                   class="form-control @error('lema') is-invalid @enderror" 
                                                   id="lema" 
                                                   name="lema" 
                                                   value="{{ old('lema') }}">
                                            @error('lema')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información Adicional -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Adicional</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="circunscripcion" class="form-label">Circunscripción *</label>
                                            <input type="text" 
                                                   class="form-control @error('circunscripcion') is-invalid @enderror" 
                                                   id="circunscripcion" 
                                                   name="circunscripcion" 
                                                   value="{{ old('circunscripcion') }}" 
                                                   required>
                                            @error('circunscripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="fecha_eleccion" class="form-label">Fecha de Elección *</label>
                                            <input type="date" 
                                                   class="form-control @error('fecha_eleccion') is-invalid @enderror" 
                                                   id="fecha_eleccion" 
                                                   name="fecha_eleccion" 
                                                   value="{{ old('fecha_eleccion') }}" 
                                                   required>
                                            @error('fecha_eleccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="color_principal" class="form-label">Color Principal</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                       class="form-control form-control-color @error('color_principal') is-invalid @enderror" 
                                                       id="color_principal" 
                                                       name="color_principal" 
                                                       value="{{ old('color_principal', '#007bff') }}"
                                                       title="Seleccionar color">
                                                <input type="text" 
                                                       class="form-control @error('color_principal') is-invalid @enderror" 
                                                       value="{{ old('color_principal', '#007bff') }}"
                                                       readonly>
                                            </div>
                                            @error('color_principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="imagen" class="form-label">Imagen del Candidato</label>
                                            <input type="file" 
                                                   class="form-control @error('imagen') is-invalid @enderror" 
                                                   id="imagen" 
                                                   name="imagen" 
                                                   accept="image/*">
                                            <div class="form-text">
                                                Tamaño recomendado: 400x400px. Formatos: JPG, PNG, GIF.
                                            </div>
                                            @error('imagen')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="activo" 
                                                       name="activo" 
                                                       value="1" 
                                                       {{ old('activo', 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activo">
                                                    Candidato activo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Biografía -->
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Biografía</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="biografia" class="form-label">Biografía del Candidato</label>
                                        <textarea class="form-control @error('biografia') is-invalid @enderror" 
                                                  id="biografia" 
                                                  name="biografia" 
                                                  rows="5">{{ old('biografia') }}</textarea>
                                        @error('biografia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('candidatos.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar Candidato
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sincronizar color picker con input de texto
        const colorPicker = document.getElementById('color_principal');
        const colorText = document.querySelector('input[name="color_principal"] + .form-control');
        
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });
        
        colorText.addEventListener('input', function() {
            colorPicker.value = this.value;
        });
    });
</script>
