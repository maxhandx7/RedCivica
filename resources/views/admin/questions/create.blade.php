@extends('layouts.admin')
@section('title', 'Crear Pregunta')
@section('styles')
<link href="{{ asset('falcon/css/tabler.min.css') }}" rel="stylesheet>
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
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Crear Nueva Pregunta</h5>
    </div>
    <div class="card-body">
        @include('alert.message')
        
        <form id="surveyForm" action="{{ route('questions.store') }}" method="POST">
            @csrf
            
            <div class="location-selector">
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
                            <select class="form-select" id="city_id" name="city_id" required disabled>
                                <option value="">-- Primero selecciona un departamento --</option>
                            </select>
                            <div id="cities-loading" class="mt-2">
                                <small class="text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando ciudades...</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="question_type" class="form-label">Tipo de Pregunta <span class="text-danger">*</span></label>
                        <select class="form-select" id="question_type" name="question_type" required>
                            <option value="" selected disabled>Seleccione opcion</option>
                            <option value="multiple_choice">Opción Múltiple</option>
                            {{-- <option value="text">Texto</option>
                            <option value="rating">Calificación</option> --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check pt-4">
                        <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1">
                        <label class="form-check-label" for="is_required">Pregunta obligatoria</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="question_text" class="form-label">Texto de la Pregunta <span class="text-danger">*</span></label>
                <textarea class="form-control" id="question_text" name="question_text" rows="3" required placeholder="Ingresa el texto de la pregunta"></textarea>
            </div>

            <!-- Opciones para preguntas de opción múltiple -->
            <div id="options-section" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Opciones de Respuesta <span class="text-danger">*</span></label>
                    <div id="options-container">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="options[]" placeholder="Opción 1" required>
                            <button type="button" class="btn btn-outline-danger remove-option">×</button>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="options[]" placeholder="Opción 2" required>
                            <button type="button" class="btn btn-outline-danger remove-option">×</button>
                        </div>
                    </div>
                    <button type="button" id="add-option" class="btn btn-sm btn-secondary mt-2">
                        <i class="fas fa-plus me-1"></i> Agregar Opción
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('questions.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Pregunta</button>
            </div>
        </form>
    </div>
</div>

<!-- Template para nuevas opciones -->
<template id="option-template">
    <div class="input-group mb-2">
        <input type="text" class="form-control" name="options[]" placeholder="Nueva opción" required>
        <button type="button" class="btn btn-outline-danger remove-option">×</button>
    </div>
</template>
@endsection

@section('scripts')
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const colombiaGeonameId = 3686110;
    const username = 'Alan';
    const departmentSelect = document.getElementById('department_id');
    const citySelect = document.getElementById('city_id');
    const departmentsLoading = document.getElementById('departments-loading');
    const citiesLoading = document.getElementById('cities-loading');
    
    // Cargar departamentos de Colombia desde Geonames
    function loadColombianDepartments() {
        departmentsLoading.style.display = 'block';
        
        fetch(`https://secure.geonames.org/childrenJSON?geonameId=${colombiaGeonameId}&username=${username}`)
            .then(response => response.json())
            .then(data => {
                departmentsLoading.style.display = 'none';
                
                if (data.geonames && data.geonames.length > 0) {
                    // Filtrar departamentos (nivel administrativo 1)
                    const departments = data.geonames.filter(place => 
                        place.fcode === 'ADM1' || place.adminCode1
                    );
                    
                    departments.forEach(dept => {
                        const cleanName = dept.name.replace(' Department', '');
                        const option = document.createElement('option');
                        option.value = dept.geonameId;
                        option.textContent = cleanName;
                        option.setAttribute('data-admin-code', dept.adminCode1);
                        departmentSelect.appendChild(option);
                    });
                    
                    if (departments.length === 0) {
                        loadDefaultDepartments();
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
    
    // Cargar departamentos por defecto en caso de error
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
            option.setAttribute('data-admin-code', dept.id);
            departmentSelect.appendChild(option);
        });
    }
    
    // Cargar ciudades cuando se selecciona un departamento
    departmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const adminCode = selectedOption.getAttribute('data-admin-code');
        
        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="">-- Cargando ciudades --</option>';
        
        if (this.value) {
            citiesLoading.style.display = 'block';
            
            // Buscar ciudades del departamento seleccionado
            fetch(`https://secure.geonames.org/searchJSON?country=CO&adminCode1=${adminCode}&maxRows=50&username=${username}`)
                .then(response => response.json())
                .then(data => {
                    citiesLoading.style.display = 'none';
                    citySelect.innerHTML = '<option value="">-- Seleccionar ciudad --</option>';
                    
                    if (data.geonames && data.geonames.length > 0) {
                        data.geonames.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.geonameId;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                    } else {
                        citySelect.innerHTML = '<option value="">-- No se encontraron ciudades --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error cargando ciudades:', error);
                    citiesLoading.style.display = 'none';
                    citySelect.innerHTML = '<option value="">-- Error al cargar --</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">-- Primero selecciona un departamento --</option>';
            citySelect.disabled = true;
        }
    });
    
    // Manejar la visibilidad de las opciones según el tipo de pregunta
    document.getElementById('question_type').addEventListener('change', function() {
        const optionsSection = document.getElementById('options-section');
        if (this.value === 'multiple_choice') {
            optionsSection.style.display = 'block';
        } else {
            optionsSection.style.display = 'none';
        }
    });
    
    // Agregar nueva opción
    document.getElementById('add-option').addEventListener('click', function() {
        const template = document.getElementById('option-template');
        const clone = template.content.cloneNode(true);
        document.getElementById('options-container').appendChild(clone);
        
        // Agregar evento al botón de eliminar
        const removeBtn = document.getElementById('options-container').lastElementChild.querySelector('.remove-option');
        removeBtn.addEventListener('click', function() {
            this.closest('.input-group').remove();
        });
    });
    
    // Eliminar opción (evento delegado)
    document.getElementById('options-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.input-group').remove();
        }
    });
    
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
            let emptyOptions = 0;
            
            options.forEach(option => {
                if (!option.value.trim()) {
                    emptyOptions++;
                }
            });
            
            if (emptyOptions > 0 || options.length < 2) {
                e.preventDefault();
                alert('Las preguntas de opción múltiple deben tener al menos 2 opciones válidas');
                return;
            }
        }
    });
    
    // Cargar departamentos al iniciar
    loadColombianDepartments();
});
</script> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colombiaGeonameId = 3686110; // ID fijo de Colombia en Geonames
    const username = 'Alan';
    const departmentSelect = document.getElementById('department_id');
    const citySelect = document.getElementById('city_id');
    const departmentsLoading = document.getElementById('departments-loading');
    const citiesLoading = document.getElementById('cities-loading');

    // Cargar departamentos de Colombia desde Geonames (sin filtros)
    function loadColombianDepartments() {
        departmentsLoading.style.display = 'block';

        fetch(`https://secure.geonames.org/childrenJSON?geonameId=${colombiaGeonameId}&username=${username}`)
            .then(response => response.json())
            .then(data => {
                departmentsLoading.style.display = 'none';
                departmentSelect.innerHTML = '<option value="">-- Seleccionar departamento --</option>';

                if (data.geonames && data.geonames.length > 0) {
                    // usamos todos los hijos tal cual, sin filtrar ni limpiar
                    data.geonames.forEach(dept => {
                        const cleanName = dept.name.replace(' Department', '');
                        const option = document.createElement('option');
                        option.value = dept.geonameId;      // ID real de Geonames
                        option.textContent = cleanName;     // Nombre tal cual
                        departmentSelect.appendChild(option);
                    });
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

    // Cargar departamentos por defecto en caso de error
    function loadDefaultDepartments() {
        const defaultDepartments = [
            { id: '3689770', name: 'Antioquia' },
            { id: '3688649', name: 'Cundinamarca' },
            { id: '3666304', name: 'Valle del Cauca' },
            { id: '3689710', name: 'Atlántico' },
            { id: '3688655', name: 'Bolívar' }
        ];
        defaultDepartments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id;
            option.textContent = dept.name;
            departmentSelect.appendChild(option);
        });
    }

    // Cargar ciudades cuando se selecciona un departamento (consulta por geonameId del dpto)
    departmentSelect.addEventListener('change', function() {
        const deptId = this.value;
        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="">-- Cargando ciudades --</option>';

        if (deptId) {
            citiesLoading.style.display = 'block';

            // Se buscan los hijos directos (municipios/ciudades) de ese departamento
            fetch(`https://secure.geonames.org/childrenJSON?geonameId=${deptId}&username=${username}`)
                .then(response => response.json())
                .then(data => {
                    citiesLoading.style.display = 'none';
                    citySelect.innerHTML = '<option value="">-- Seleccionar ciudad --</option>';

                    if (data.geonames && data.geonames.length > 0) {
                        data.geonames.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.geonameId;  // ID real de Geonames
                            option.textContent = city.name; // Nombre tal cual
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                    } else {
                        citySelect.innerHTML = '<option value="">-- No se encontraron ciudades --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error cargando ciudades:', error);
                    citiesLoading.style.display = 'none';
                    citySelect.innerHTML = '<option value="">-- Error al cargar --</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">-- Primero selecciona un departamento --</option>';
            citySelect.disabled = true;
        }
    });

    // Manejar la visibilidad de las opciones según el tipo de pregunta
    document.getElementById('question_type').addEventListener('change', function() {
        const optionsSection = document.getElementById('options-section');
        optionsSection.style.display = this.value === 'multiple_choice' ? 'block' : 'none';
    });

    // Agregar nueva opción
    document.getElementById('add-option').addEventListener('click', function() {
        const template = document.getElementById('option-template');
        const clone = template.content.cloneNode(true);
        document.getElementById('options-container').appendChild(clone);
    });

    // Eliminar opción (evento delegado)
    document.getElementById('options-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.input-group').remove();
        }
    });

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
            const valid = [...options].filter(o => o.value.trim()).length >= 2;
            if (!valid) {
                e.preventDefault();
                alert('Las preguntas de opción múltiple deben tener al menos 2 opciones válidas');
            }
        }
    });

    // Cargar departamentos al iniciar
    loadColombianDepartments();
});
</script>

@endsection