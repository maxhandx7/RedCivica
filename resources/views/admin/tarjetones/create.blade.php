<!-- resources/views/admin/tarjetones/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Crear Tarjetón')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Crear Nuevo Tarjetón Electoral</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tarjetones.store') }}" method="POST" id="tarjetonForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información Básica</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="candidato_id" class="form-label">Candidato *</label>
                                        <select class="form-select @error('candidato_id') is-invalid @enderror" 
                                                id="candidato_id" 
                                                name="candidato_id" 
                                                required>
                                            <option value="">Seleccionar candidato...</option>
                                            @foreach($candidatos as $candidato)
                                                <option value="{{ $candidato->id }}" {{ old('candidato_id') == $candidato->id ? 'selected' : '' }}>
                                                    {{ $candidato->nombre_completo }} - {{ $candidato->cargo_formateado }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('candidato_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre del Tarjetón *</label>
                                        <input type="text" 
                                               class="form-control @error('nombre') is-invalid @enderror" 
                                               id="nombre" 
                                               name="nombre" 
                                               value="{{ old('nombre') }}" 
                                               required
                                               placeholder="Ej: Tarjetón para el Senado 2026">
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="total_opciones" class="form-label">Total de Opciones *</label>
                                        <input type="number" 
                                               class="form-control @error('total_opciones') is-invalid @enderror" 
                                               id="total_opciones" 
                                               name="total_opciones" 
                                               value="{{ old('total_opciones', 100) }}" 
                                               required
                                               min="1"
                                               max="1000">
                                        <div class="form-text">Número total de opciones en el tarjetón (máximo 1000)</div>
                                        @error('total_opciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="instruccion" class="form-label">Instrucción para el Votante</label>
                                        <textarea class="form-control @error('instruccion') is-invalid @enderror" 
                                                  id="instruccion" 
                                                  name="instruccion" 
                                                  rows="3">{{ old('instruccion', 'MARCAR MÁS DE UNA LISTA ANULA EL VOTO') }}</textarea>
                                        @error('instruccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="activo" 
                                                   name="activo" 
                                                   value="1" 
                                                   {{ old('activo', 1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="activo">
                                                Tarjetón activo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Configuración -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración Visual</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="color_primario" class="form-label">Color Primario</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                       class="form-control form-control-color" 
                                                       id="color_primario" 
                                                       name="configuracion[color_primario]" 
                                                       value="{{ old('configuracion.color_primario', '#007bff') }}">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="{{ old('configuracion.color_primario', '#007bff') }}"
                                                       readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="color_secundario" class="form-label">Color Secundario</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                       class="form-control form-control-color" 
                                                       id="color_secundario" 
                                                       name="configuracion[color_secundario]" 
                                                       value="{{ old('configuracion.color_secundario', '#6c757d') }}">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="{{ old('configuracion.color_secundario', '#6c757d') }}"
                                                       readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="mostrar_numeros" 
                                                       name="configuracion[mostrar_numeros]" 
                                                       value="1" 
                                                       {{ old('configuracion.mostrar_numeros', 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mostrar_numeros">
                                                    Mostrar números de opción
                                                </label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="mostrar_nombres" 
                                                       name="configuracion[mostrar_nombres]" 
                                                       value="1" 
                                                       {{ old('configuracion.mostrar_nombres', 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mostrar_nombres">
                                                    Mostrar nombres de secciones
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Vista Previa -->
                            <div class="card mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Vista Previa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="border rounded p-3" id="previewContainer" style="min-height: 200px; background-color: #f8f9fa;">
                                        <div class="text-center text-muted">
                                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                            <p>La vista previa se actualizará automáticamente</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Secciones del Tarjetón -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Secciones del Tarjetón</h6>
                                    <button type="button" class="btn btn-sm btn-primary" id="addSection">
                                        <i class="fas fa-plus me-1"></i> Agregar Sección
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="sectionsContainer">
                                        <!-- Las secciones se agregarán aquí dinámicamente -->
                                        <div class="section-item card mb-3">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nombre de la Sección *</label>
                                                        <input type="text" 
                                                               name="secciones[0][nombre]" 
                                                               class="form-control section-name" 
                                                               value="{{ old('secciones.0.nombre', 'PARTIDO') }}"
                                                               required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Desde *</label>
                                                        <input type="number" 
                                                               name="secciones[0][inicio]" 
                                                               class="form-control section-start" 
                                                               value="{{ old('secciones.0.inicio', 1) }}"
                                                               min="1"
                                                               required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Hasta *</label>
                                                        <input type="number" 
                                                               name="secciones[0][fin]" 
                                                               class="form-control section-end" 
                                                               value="{{ old('secciones.0.fin', 12) }}"
                                                               min="1"
                                                               required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Total</label>
                                                        <input type="text" 
                                                               class="form-control section-total" 
                                                               value="12"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-section d-none">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <div class="alert alert-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>Resumen:</strong>
                                                    <span id="totalSections">1</span> sección(es) | 
                                                    <span id="totalOptions">12</span> opciones de 
                                                    <span id="requiredOptions">100</span>
                                                </div>
                                                <div id="validationMessage">
                                                    <span class="text-success">
                                                        <i class="fas fa-check-circle"></i> Válido
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('tarjetones.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    <i class="fas fa-save me-2"></i> Guardar Tarjetón
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
    .section-item {
        border-left: 4px solid #007bff;
        transition: all 0.3s ease;
    }
    
    .section-item:hover {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .section-total {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .validation-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .validation-success {
        color: #28a745;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables
    let sectionCount = 1;
    const totalOptionsInput = document.getElementById('total_opciones');
    const sectionsContainer = document.getElementById('sectionsContainer');
    const totalSectionsSpan = document.getElementById('totalSections');
    const totalOptionsSpan = document.getElementById('totalOptions');
    const requiredOptionsSpan = document.getElementById('requiredOptions');
    const validationMessage = document.getElementById('validationMessage');
    const previewContainer = document.getElementById('previewContainer');
    const submitButton = document.getElementById('submitButton');
    
    // Inicializar
    requiredOptionsSpan.textContent = totalOptionsInput.value;
    updateValidation();
    updatePreview();
    
    // Agregar nueva sección
    document.getElementById('addSection').addEventListener('click', function() {
        const newIndex = sectionCount;
        
        const sectionHTML = `
            <div class="section-item card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nombre de la Sección *</label>
                            <input type="text" 
                                   name="secciones[${newIndex}][nombre]" 
                                   class="form-control section-name" 
                                   value="SECCIÓN ${newIndex + 1}"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Desde *</label>
                            <input type="number" 
                                   name="secciones[${newIndex}][inicio]" 
                                   class="form-control section-start" 
                                   value="${(newIndex * 12) + 1}"
                                   min="1"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hasta *</label>
                            <input type="number" 
                                   name="secciones[${newIndex}][fin]" 
                                   class="form-control section-end" 
                                   value="${(newIndex + 1) * 12}"
                                   min="1"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Total</label>
                            <input type="text" 
                                   class="form-control section-total" 
                                   value="12"
                                   readonly>
                        </div>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-section">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        sectionsContainer.insertAdjacentHTML('beforeend', sectionHTML);
        sectionCount++;
        
        // Actualizar cálculos
        updateSectionCalculations();
        updateValidation();
        updatePreview();
        
        // Mostrar botones eliminar en todas las secciones excepto la primera
        updateRemoveButtons();
    });
    
    // Eliminar sección
    sectionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-section')) {
            const sectionItem = e.target.closest('.section-item');
            if (sectionCount > 1) {
                sectionItem.remove();
                sectionCount--;
                
                // Renumerar las secciones restantes
                renumberSections();
                updateSectionCalculations();
                updateValidation();
                updatePreview();
                updateRemoveButtons();
            }
        }
    });
    
    // Actualizar cálculos de sección
    function updateSectionCalculations() {
        const sectionItems = document.querySelectorAll('.section-item');
        let totalCalculated = 0;
        
        sectionItems.forEach((item, index) => {
            const startInput = item.querySelector('.section-start');
            const endInput = item.querySelector('.section-end');
            const totalInput = item.querySelector('.section-total');
            
            const start = parseInt(startInput.value) || 1;
            const end = parseInt(endInput.value) || start;
            const total = Math.max(0, end - start + 1);
            
            totalInput.value = total;
            totalCalculated += total;
            
            // Asegurar que el siguiente empiece donde termina el anterior + 1
            if (index < sectionItems.length - 1) {
                const nextStartInput = sectionItems[index + 1].querySelector('.section-start');
                nextStartInput.value = end + 1;
                nextStartInput.min = end + 1;
            }
        });
        
        totalSectionsSpan.textContent = sectionItems.length;
        totalOptionsSpan.textContent = totalCalculated;
    }
    
    // Renumerar secciones después de eliminar
    function renumberSections() {
        const sectionItems = document.querySelectorAll('.section-item');
        
        sectionItems.forEach((item, index) => {
            // Renombrar inputs
            const inputs = item.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                const name = input.name;
                if (name.includes('secciones[')) {
                    input.name = name.replace(/secciones\[\d+\]/, `secciones[${index}]`);
                }
            });
            
            // Actualizar valor por defecto del nombre
            const nameInput = item.querySelector('.section-name');
            if (nameInput.value.startsWith('SECCIÓN') || !nameInput.value.trim()) {
                nameInput.value = `SECCIÓN ${index + 1}`;
            }
        });
    }
    
    // Actualizar botones eliminar
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-section');
        removeButtons.forEach(button => {
            button.classList.remove('d-none');
        });
        
        // Ocultar en la primera sección si solo hay una
        if (sectionCount === 1) {
            removeButtons[0]?.classList.add('d-none');
        }
    }
    
    // Validar tarjetón
    function updateValidation() {
        const requiredOptions = parseInt(totalOptionsInput.value) || 0;
        const sectionItems = document.querySelectorAll('.section-item');
        let totalCalculated = 0;
        let isValid = true;
        let message = '';
        
        sectionItems.forEach(item => {
            const start = parseInt(item.querySelector('.section-start').value) || 0;
            const end = parseInt(item.querySelector('.section-end').value) || 0;
            
            if (start > end) {
                isValid = false;
                message = 'Error: "Desde" no puede ser mayor que "Hasta"';
            }
            
            totalCalculated += Math.max(0, end - start + 1);
        });
        
        if (totalCalculated === 0) {
            isValid = false;
            message = 'Error: No hay opciones definidas';
        } else if (totalCalculated > requiredOptions) {
            isValid = false;
            message = `Error: Excede el total permitido (${totalCalculated} > ${requiredOptions})`;
        } else if (totalCalculated < requiredOptions) {
            message = `Advertencia: Faltan ${requiredOptions - totalCalculated} opciones`;
            validationMessage.innerHTML = `<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> ${message}</span>`;
        } else {
            message = 'Perfecto: Todas las opciones están asignadas';
            validationMessage.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> ${message}</span>`;
        }
        
        // Actualizar estado del botón de envío
        submitButton.disabled = !isValid;
        
        return isValid;
    }
    
    // Actualizar vista previa
    function updatePreview() {
        const sectionItems = document.querySelectorAll('.section-item');
        const colorPrimario = document.getElementById('color_primario').value;
        
        let previewHTML = `
            <div class="text-center mb-3">
                <h5 class="mb-2" style="color: ${colorPrimario}">VISTA PREVIA DEL TARJETÓN</h5>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    <i class="fas fa-info-circle"></i> ${document.getElementById('instruccion').value || 'Instrucción no definida'}
                </p>
            </div>
            <hr>
        `;
        
        sectionItems.forEach((item, index) => {
            const nombre = item.querySelector('.section-name').value || `Sección ${index + 1}`;
            const start = parseInt(item.querySelector('.section-start').value) || 1;
            const end = parseInt(item.querySelector('.section-end').value) || start;
            const total = parseInt(item.querySelector('.section-total').value) || 0;
            
            previewHTML += `
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0" style="color: ${colorPrimario}">${nombre}</h6>
                        <span class="badge" style="background-color: ${colorPrimario}">${total} opciones</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1">
            `;
            
            for (let i = start; i <= end; i++) {
                previewHTML += `
                    <div class="border rounded text-center" 
                         style="width: 40px; height: 40px; line-height: 40px; font-size: 0.9rem; background-color: #f8f9fa;">
                        ${i}
                    </div>
                `;
            }
            
            previewHTML += `
                    </div>
                </div>
            `;
        });
        
        previewHTML += `
            <div class="mt-3 text-center">
                <small class="text-muted">
                    Total: <strong>${totalOptionsSpan.textContent}</strong> opciones en <strong>${sectionItems.length}</strong> secciones
                </small>
            </div>
        `;
        
        previewContainer.innerHTML = previewHTML;
    }
    
    // Event Listeners para actualizaciones en tiempo real
    sectionsContainer.addEventListener('input', function(e) {
        if (e.target.classList.contains('section-start') || 
            e.target.classList.contains('section-end') ||
            e.target.classList.contains('section-name')) {
            updateSectionCalculations();
            updateValidation();
            updatePreview();
        }
    });
    
    totalOptionsInput.addEventListener('input', function() {
        requiredOptionsSpan.textContent = this.value;
        updateValidation();
        updatePreview();
    });
    
    document.getElementById('instruccion').addEventListener('input', updatePreview);
    document.getElementById('color_primario').addEventListener('input', updatePreview);
    document.getElementById('color_secundario').addEventListener('input', updatePreview);
    
    // Validación del formulario antes de enviar
    document.getElementById('tarjetonForm').addEventListener('submit', function(e) {
        if (!updateValidation()) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                text: 'Por favor, corrige los errores en las secciones del tarjetón.',
                confirmButtonText: 'Entendido'
            });
        }
    });
    
    // Inicializar botones eliminar
    updateRemoveButtons();
});
</script>