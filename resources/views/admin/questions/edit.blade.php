@extends('layouts.admin')
@section('title', 'Editar Pregunta')
@section('styles')
<link href="{{ asset('falcon/css/tabler.min.css') }}" rel="stylesheet">
<style>
    .location-selector {
        margin-bottom: 20px;
    }
    .dynamic-questions {
        border-left: 3px solid #3498db;
        padding-left: 15px;
        margin-top: 20px;
    }
    .question-group {
        margin-bottom: 25px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    #cities-loading, #departments-loading {
        display: none;
    }
    .option-item {
        margin-bottom: 10px;
    }
    .remove-option {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editar Pregunta</h5>
            <a href="{{ route('questions.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver al listado
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('alert.message')
        
        <form id="surveyForm" action="{{ route('questions.update', $question) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- <div class="location-selector">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Departamento <span class="text-danger">*</span></label>
                            <select class="form-select" id="department_id" name="department_id" required>
                                <option value="">-- Seleccionar departamento --</option>
                            </select>
                            <div id="departments-loading" class="mt-2">
                                <small class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando departamentos...</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <select class="form-select" id="city_id" name="city_id" required>
                                <option value="">-- Seleccionar ciudad --</option>
                            </select>
                            <div id="cities-loading" class="mt-2">
                                <small class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando ciudades...</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="question_type" class="form-label">Tipo de Pregunta <span class="text-danger">*</span></label>
                        <select class="form-select" id="question_type" name="question_type" required>
                            <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>Opción Múltiple</option>
                            <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Texto</option>
                            <option value="rating" {{ $question->question_type == 'rating' ? 'selected' : '' }}>Calificación</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check pt-4">
                        <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_required">Pregunta obligatoria</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="question_text" class="form-label">Texto de la Pregunta <span class="text-danger">*</span></label>
                <textarea class="form-control" id="question_text" name="question_text" rows="3" required placeholder="Ingresa el texto de la pregunta">{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            <!-- Opciones para preguntas de opción múltiple -->
            <div id="options-section" style="{{ $question->question_type != 'multiple_choice' ? 'display: none;' : '' }}">
                <div class="mb-3">
                    <label class="form-label">Opciones de Respuesta <span class="text-danger">*</span></label>
                    <div id="options-container">
                        @if($question->question_type == 'multiple_choice' && $question->options)
                            @foreach($question->options as $index => $option)
                                <div class="input-group mb-2 option-item">
                                    <input type="text" class="form-control" name="options[]" value="{{ $option }}" placeholder="Opción {{ $index + 1 }}" required>
                                    <button type="button" class="btn btn-outline-danger remove-option" {{ $index < 2 ? 'disabled' : '' }}>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2 option-item">
                                <input type="text" class="form-control" name="options[]" placeholder="Opción 1" required>
                                <button type="button" class="btn btn-outline-danger remove-option" disabled>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="input-group mb-2 option-item">
                                <input type="text" class="form-control" name="options[]" placeholder="Opción 2" required>
                                <button type="button" class="btn btn-outline-danger remove-option" disabled>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-option" class="btn btn-sm btn-secondary mt-2">
                        <i class="fas fa-plus me-1"></i> Agregar Opción
                    </button>
                    <small class="form-text text-muted">Mínimo 2 opciones requeridas</small>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('questions.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Actualizar Pregunta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Template para nuevas opciones -->
<template id="option-template">
    <div class="input-group mb-2 option-item">
        <input type="text" class="form-control" name="options[]" placeholder="Nueva opción" required>
        <button type="button" class="btn btn-outline-danger remove-option">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const username = 'Alan';
    const currentDepartmentId = '{{ $question->department_id }}';
    const currentCityId = {{ $question->city_id }};
    
    const departmentSelect = document.getElementById('department_id');
    const citySelect = document.getElementById('city_id');
    const departmentsLoading = document.getElementById('departments-loading');
    const citiesLoading = document.getElementById('cities-loading');
    
    // Cargar departamentos de Colombia
    function loadColombianDepartments() {
        departmentsLoading.style.display = 'block';
        
        fetch('{{ route("questions.departments") }}')
            .then(response => response.json())
            .then(data => {
                departmentsLoading.style.display = 'none';
                
                if (data.success && data.departments.length > 0) {
                    data.departments.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.adminCode1 || dept.geonameId;
                        option.textContent = dept.name;
                        option.setAttribute('data-geoname-id', dept.geonameId);
                        
                        if (dept.adminCode1 === currentDepartmentId || dept.geonameId === currentDepartmentId) {
                            option.selected = true;
                        }
                        
                        departmentSelect.appendChild(option);
                    });
                    
                    // Si hay un departamento seleccionado, cargar sus ciudades
                    if (currentDepartmentId) {
                        loadCitiesForDepartment(currentDepartmentId);
                    }
                } else {
                    loadDefaultDepartments();
                }
            })
            .catch(error => {
                console.error('Error cargando departamentos:', error);
                departmentsLoading.style.display = 'none';
                loadDefaultDepartments();
            });
    }
    
    // Cargar departamentos por defecto
    function loadDefaultDepartments() {
        const defaultDepartments = [
            { id: 'ANT', name: 'Antioquia' },
            { id: 'CUN', name: 'Cundinamarca' },
            { id: 'VAL', name: 'Valle del Cauca' },
            { id: 'ATL', name: 'Atlántico' },
            { id: 'BOL', name: 'Bolívar' }
        ];
        
        defaultDepartments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id;
            option.textContent = dept.name;
            
            if (dept.id === currentDepartmentId) {
                option.selected = true;
                loadCitiesForDepartment(currentDepartmentId);
            }
            
            departmentSelect.appendChild(option);
        });
    }
    
    // Cargar ciudades para un departamento
    function loadCitiesForDepartment(departmentCode) {
        citiesLoading.style.display = 'block';
        citySelect.innerHTML = '<option value="">-- Cargando ciudades --</option>';
        citySelect.disabled = true;
        
        fetch(`/questions/cities/${departmentCode}`)
            .then(response => response.json())
            .then(data => {
                citiesLoading.style.display = 'none';
                citySelect.innerHTML = '<option value="">-- Seleccionar ciudad --</option>';
                
                if (data.success && data.cities.length > 0) {
                    data.cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.geonameId;
                        option.textContent = city.name;
                        
                        if (city.geonameId == currentCityId) {
                            option.selected = true;
                        }
                        
                        citySelect.appendChild(option);
                    });
                } else {
                    citySelect.innerHTML = '<option value="">-- No se encontraron ciudades --</option>';
                }
                citySelect.disabled = false;
            })
            .catch(error => {
                console.error('Error cargando ciudades:', error);
                citiesLoading.style.display = 'none';
                citySelect.innerHTML = '<option value="">-- Error al cargar --</option>';
                citySelect.disabled = false;
            });
    }
    
    // Event listener para cambio de departamento
    departmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const departmentCode = this.value;
        
        if (departmentCode) {
            loadCitiesForDepartment(departmentCode);
        } else {
            citySelect.innerHTML = '<option value="">-- Selecciona un departamento primero --</option>';
            citySelect.disabled = true;
        }
    });
    
    // Manejar visibilidad de opciones
    document.getElementById('question_type').addEventListener('change', function() {
        const optionsSection = document.getElementById('options-section');
        if (this.value === 'multiple_choice') {
            optionsSection.style.display = 'block';
            // Asegurar al menos 2 opciones
            ensureMinimumOptions(2);
        } else {
            optionsSection.style.display = 'none';
        }
    });
    
    // Asegurar mínimo de opciones
    function ensureMinimumOptions(min) {
        const currentOptions = document.querySelectorAll('#options-container .option-item');
        if (currentOptions.length < min) {
            for (let i = currentOptions.length; i < min; i++) {
                addNewOption();
            }
        }
    }
    
    // Agregar nueva opción
    document.getElementById('add-option').addEventListener('click', addNewOption);
    
    function addNewOption() {
        const template = document.getElementById('option-template');
        const clone = template.content.cloneNode(true);
        document.getElementById('options-container').appendChild(clone);
        
        // Habilitar botones de eliminar si hay más de 2 opciones
        updateRemoveButtons();
    }
    
    // Eliminar opción (evento delegado)
    document.getElementById('options-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-option')) {
            const optionItem = e.target.closest('.option-item');
            if (document.querySelectorAll('.option-item').length > 2) {
                optionItem.remove();
                updateRemoveButtons();
            }
        }
    });
    
    // Actualizar estado de botones de eliminar
    function updateRemoveButtons() {
        const optionItems = document.querySelectorAll('.option-item');
        const removeButtons = document.querySelectorAll('.remove-option');
        
        removeButtons.forEach(btn => {
            btn.disabled = optionItems.length <= 2;
        });
    }
    
    // Validación del formulario
    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        const questionType = document.getElementById('question_type').value;
        const cityId = document.getElementById('city_id').value;
        
        if (!cityId) {
            e.preventDefault();
            alert('Por favor selecciona una ciudad');
            return;
        }
        
        if (questionType === 'multiple_choice') {
            const options = document.querySelectorAll('input[name="options[]"]');
            let validOptions = 0;
            
            options.forEach(option => {
                if (option.value.trim()) {
                    validOptions++;
                }
            });
            
            if (validOptions < 2) {
                e.preventDefault();
                alert('Las preguntas de opción múltiple deben tener al menos 2 opciones válidas');
                return;
            }
        }
    });
    
    // Inicializar
    loadColombianDepartments();
    updateRemoveButtons();
});
</script>
@endsection