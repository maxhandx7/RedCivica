<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .theme-wizard .nav-wizard .nav-item {
        flex: 1;
        text-align: center;
    }

    .nav-item-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        margin: 0 auto;
    }

    .nav-link.active .nav-item-circle {
        background-color: #e00000;
        color: white;
    }

    .wizard-lottie-wrapper {
        height: 150px;
    }

    .form-label {
        font-weight: 500;
    }

    .wizard-lottie-wrapper {
        display: none;
    }

    .btn-primary {
        background-color: #e00000;
        border-color: #e00000;
    }

    .card-header {
        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
        color: white;
    }

    .data-item {
        border-left: 3px solid #0dcaf0;
        padding-left: 15px;
        margin-bottom: 12px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .data-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .big-checkbox {
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .big-checkbox:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .form-check-label {
        font-size: 1.1rem;
        cursor: pointer;
    }

    .form-check-label a {
        font-weight: bold;
        color: #0d6efd;
        text-decoration: underline;
    }
</style>


<body>
    <div class="container my-5">
        <div class="card theme-wizard" id="wizard" data-toggle="validator" role="form" novalidate>
            <div class="bg-body-tertiary">
                <ul class="nav justify-content-between nav-wizard">
                    <li class="nav-item">
                        <a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab"
                            data-wizard-step="1">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <span class="fas fa-user"></span>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs-10">Personal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab"
                            data-wizard-step="2">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <span class="fas fa-map-marker-alt"></span>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs-10">Ubicación</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab"
                            data-wizard-step="3">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <span class="fas fa-clipboard-check"></span>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs-10">Confirmación</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab"
                            data-wizard-step="4">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <span class="fas fa-thumbs-up"></span>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs-10">Fin</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body py-1" id="wizard-controller">
                <div class="tab-content">
                    <!-- Paso 1: Datos Personales -->
                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1"
                        id="bootstrap-wizard-tab1">
                        <div class="container text-center">
                            <h3>Datos personales</h3>
                            <p class="text-muted" style="margin-bottom: 0px !important; ">Ingresa tus datos personales para que sepamos de ti.</p>
                            <small class="text-muted" style="margin-bottom: 1rem !important; color: #e00000;">Los campos marcados con * son obligatorios.</small>
                            <div class="row">
                                <!-- Nombre -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">Nombre*</label>
                                    <input class="form-control" type="text" name="name"
                                        placeholder="Dijite su nombre" id="name" required />
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>

                                <!-- Apellido -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="surname">Apellido*</label>
                                    <input class="form-control" type="text" name="surname"
                                        placeholder="Dijite su apellido" id="surname" required />
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tipo de documento -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tipo_documento">Tipo de documento*</label>
                                    <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                        <option selected disabled value="">Seleccione tipo de documento</option>
                                        <option value="cc" selected>Cedula</option>
                                        <option value="ce">Cedula de extranjeria</option>
                                        <option value="rut">Rut</option>
                                        <option value="ppt">Pasaporte</option>
                                    </select>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>

                                <!-- Numero de documento -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="cedula">Número de documento*</label>
                                    <input class="form-control" type="text" name="cedula" id="cedula"
                                        pattern="[0-9]{6,10}" maxlength="10" title="Solo números, entre 6 y 10 dígitos"
                                        placeholder="Documento (6 a 10 dígitos)"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                    <div class="invalid-feedback">Ingrese solo números (6-10 dígitos)</div>
                                </div>
                            </div>



                            <div class="row">
                                <!-- Fecha de Nacimiento -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-birthday-cake"></i>
                                        </span>
                                        <input class="form-control datepicker"  type="text"
                                            name="fecha_nacimiento" id="fecha_nacimiento" placeholder="DD/MM/AAAA"
                                            autocomplete="off"  />
                                    </div>
                                </div>

                                <!-- Fecha de Expedición -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="fecha_expedicion">Fecha de Expedición</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input class="form-control datepicker"  type="text"
                                            name="fecha_expedicion" id="fecha_expedicion" placeholder="DD/MM/AAAA"
                                            autocomplete="off"  />
                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <!-- Correo electrónico -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="email">Correo electronico</label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="name@example.com" id="email" />
                                    <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="referido_por" class="form-label">
                                        ¿Quién te invitó? <small class="text-muted">(Opcional)</small>
                                    </label>

                                    <input type="text" name="referido_por" id="referido_por" class="form-control"
                                        placeholder="Cédula de la persona que te invitó"
                                        value="{{ old('referido_por', request('ref') ?? '') }}">

                                    <small class="text-muted">
                                        Si no recuerdas o no aplica, puedes dejarlo vacío.
                                    </small>
                                </div>

                            </div>


                        </div>
                    </div>

                    <!-- Paso 2: Datos de Ubicación -->
                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                        <div class="container text-center">
                            <h3>Datos de ubicacion</h3>
                            <p class="text-muted">Donde te encuentras.</p>

                            <div class="mb-3">
                                <label class="form-label" for="pais">Pais</label>
                                <select class="form-select" name="pais" id="pais" required>
                                    <option disabled selected value="">Seleccione un país</option>
                                    <option value="3686110">Colombia</option>
                                </select>
                                <div class="invalid-feedback">Este campo es obligatorio.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="departamento">Departamento/Estado</label>
                                <select class="form-select" name="departamento" id="departamento" disabled required>
                                    <option selected disabled value="">Seleccione un estado</option>
                                </select>
                                <div class="invalid-feedback">Este campo es obligatorio.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="ciudad">Ciudad</label>
                                <select class="form-select" name="ciudad" id="ciudad" disabled required>
                                    <option selected disabled value="">Seleccione una ciudad</option>
                                </select>
                                <div class="invalid-feedback">Este campo es obligatorio.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="direccion">Dirección</label>
                                <input class="form-control" id="direccion" name="direccion" type="text"
                                    placeholder="Digite su dirección" />
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="barrio">Barrio</label>
                                    <input class="form-control" id="barrio" name="barrio" type="text"
                                        placeholder="Centro" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="comuna">Comuna/Localidad</label>
                                    <input class="form-control" id="comuna" name="comuna" type="text"
                                        placeholder="Comuna 18/Chapinero" />
                                </div>
                            </div>
                            <div class="row">
                                <!-- Teléfono -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="telefono">Telefono</label>
                                    <input class="form-control" type="tel" name="telefono"
                                        data-input-mask='{"mask":"+57 (999) 999-9999"}' placeholder="(XXX) XXX-XXXX"
                                        id="telephoneInputmask" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Confirmación -->
                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">


                        <h4 class="mb-1" id="msg1">¡Revisa tus datos!</h4>
                        <p class="mb-4" id="msg2">Confirma que toda la información sea correcta antes de enviar
                        </p>

                        <div class="text-start mb-4" id="resumen-datos">
                            <!-- Los datos se llenarán con JavaScript -->
                        </div>


                    </div>

                    <!-- Paso 4: Final -->
                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                        aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">

                        <div class="wizard-lottie-wrapper">
                            <div class="lottie wizard-lottie mx-auto my-3" id="exito" hidden
                                data-options='{"path":"../falcon/public/assets/img/animated-icons/celebration.json"}'>
                            </div>
                        </div>

                        <div class="text-start mb-4" id="redatos">
                        </div>

                        <div class="form-check mb-4" id="terminos-container">
                            <input class="form-check-input big-checkbox" type="checkbox" id="terminos" required>
                            <label class="form-check-label fw-bold" for="terminos">
                                Acepto los <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#termsModal">términos y condiciones</a>
                            </label>
                            <div class="invalid-feedback">Debes aceptar los términos y condiciones</div>
                        </div>

                        <button class="btn btn-primary px-5 my-3" type="button" id="final-submit">Enviar
                            formulario</button>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-body-tertiary">
                <div class="px-sm-3 px-md-5">
                    <ul class="pager wizard list-inline mb-0">
                        <li class="previous">
                            <button class="btn btn-link ps-0" type="button" id="prev-btn">
                                <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span>Atras
                            </button>
                        </li>
                        <li class="next">
                            <button class="btn btn-primary px-5 px-sm-6" type="button" id="next-btn">
                                <span id="wizard-submit-text">Siguiente</span>
                                <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @include('admin.form._form_survey')

    <!-- Modal de Error -->
    <div class="modal fade" id="error-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative p-5">
                <div class="d-flex align-items-center">
                    <div class="lottie me-3"
                        data-options='{"path":"../falcon/public/assets/img/animated-icons/warning-light.json"}'></div>
                    <div class="flex-1">
                        <button class="btn btn-link text-danger position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal">
                            <span class="fas fa-times"></span>
                        </button>
                        <p class="mb-0" id="error-message">No tienes acceso al enlace, por favor inicia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de Question -->
    <div class="modal fade" id="question-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative p-5">
                <div class="d-flex align-items-center">
                    <div class="lottie me-3"
                        data-options='{"path":"../falcon/public/assets/img/animated-icons/check-primary-light.json"}'>
                    </div>
                    <div class="flex-1">
                        <button class="btn btn-link text-success position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal">
                            <span class="fas fa-times"></span>
                        </button>
                        <p class="mb-0 alert alert-info" id="question-message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxc1s_F585VkZIt3IFS8eZVMosLrYHtD0&libraries=places&callback=initAutocomplete"
        async defer></script>

    <script>
        $(document).ready(function() {
            const colombiaGeonameId = 3686110;
            let currentStep = 1;
            const totalSteps = 4;

            // Campos ocultos
            const hiddenFields = {
                parent_id: "{{ $referidor->id ?? null }}",
                fuente: "{{ $fuente ?? 'web' }}",
                medio: "{{ $medio ?? 'web' }}",
                referencia_id: "{{ $referencia_id ?? null }}"
            };

            // Inicializar wizard
            function initWizard() {
                updateNavigation();

                // Event listeners para botones
                $('#next-btn').on('click', goToNextStep);
                $('#prev-btn').on('click', goToPrevStep);
                //$('#final-submit').on('click', submitForm);
                $('#final-submit').on('click', submitForm);

                // Cargar departamentos cuando se selecciona Colombia
                $('#pais').on('change', loadDepartamentos);

                // Cargar ciudades cuando se selecciona un departamento
                $('#departamento').on('change', loadCiudades);
            }

            // Navegación entre pasos
            function goToNextStep() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        if (currentStep === 3) {
                            showResumen();
                        }
                        updateNavigation();
                    }
                } else {
                    console.log("No puedes avanzar, valida primero");
                    e.preventDefault();

                    return;
                    console.log("Validación fallida en el paso " + currentStep);
                }
            }

            function goToPrevStep() {

                if (currentStep > 1) {
                    currentStep--;
                    updateNavigation();
                }
            }

            function updateNavigation() {
                // Actualizar pestañas activas
                $(`#wizard .nav-link`).removeClass('active');
                $(`#wizard .nav-link[data-wizard-step="${currentStep}"]`).addClass('active');


                // Actualizar contenido visible
                $(`#wizard .tab-pane`).removeClass('active');
                $(`#bootstrap-wizard-tab${currentStep}`).addClass('active');


                // Mostrar/ocultar botones
                if (currentStep === 1) {
                    $('#prev-btn').hide();
                } else {
                    $('#prev-btn').show();
                }
                if (currentStep === totalSteps) {
                    $('#next-btn').hide();
                } else {
                    $('#next-btn').show();
                }
            }

            // Validar paso actual
            function validateStep(step) {
                let isValid = true;

                if (step === 1) {
                    // Validar campos personales
                    $('#name, #surname, #tipo_documento, #cedula').each(
                        function() {
                            if (!$(this).val()) {
                                $(this).addClass('is-invalid');
                                isValid = false;
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });

                    // Validar email
                    const email = $('#email').val();

                } else if (step === 2) {
                    // Validar campos de ubicación
                    $('#pais, #departamento, #ciudad').each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            isValid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                } else if (step === 3) {
                    showResumen();
                } else if (step === 4) {
                    // Validar aceptación de términos
                    if (!$('#terminos').is(':checked')) {
                        $('#terminos').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#terminos').removeClass('is-invalid');
                    }
                }

                return isValid;
            }

            // Mostrar resumen en el último paso
            function showResumen() {
                const resumenHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white py-2">
                                <h5 class="m-0"><i class="fa-solid fa-person me-2"></i>Datos Personales</h5>
                            </div>
                            <div class="card-body">
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fa-solid fa-circle-user me-1"></i> Nombre:</strong> ${$('#name').val()} ${$('#surname').val()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fa-solid fa-address-card me-1"></i> Tipo de documento:</strong> ${$('#tipo_documento option:selected').text()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-id-card me-1"></i> Número de documento:</strong> ${$('#cedula').val()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-envelope me-1"></i> Email:</strong> ${$('#email').val()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-calendar me-1"></i> Fecha de expedición:</strong> ${$('#fecha_expedicion').val() || 'No proporcionado'}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-birthday-cake me-1"></i> Fecha de nacimiento:</strong> ${$('#fecha_nacimiento').val() || 'No proporcionado'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white py-2">
                                <h5 class="m-0"><i class="fa-solid fa-location-dot me-2"></i>Datos de Ubicación</h5>
                            </div>
                            <div class="card-body">
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-globe-americas me-1"></i> País:</strong> ${$('#pais option:selected').text()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-map-marked-alt me-1"></i> Departamento:</strong> ${$('#departamento option:selected').text()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-city me-1"></i> Ciudad:</strong> ${$('#ciudad option:selected').text()}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-map-marker-alt me-1"></i> Dirección:</strong> ${$('#direccion').val() || 'No proporcionada'}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-home me-1"></i> Barrio:</strong> ${$('#barrio').val() || 'No proporcionado'}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-thumbtack me-1"></i> Comuna/Localidad:</strong> ${$('#comuna').val() || 'No proporcionada'}</p>
                                </div>
                                <div class="data-item">
                                    <p class="m-0"><strong><i class="fas fa-phone me-1"></i> Telefono:</strong> ${$('#telephoneInputmask').val() || 'No proporcionado'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;


                if (resumenHTML && resumenHTML.trim() !== "") {
                    $('#resumen-datos').html(resumenHTML);
                } else {
                    $('#resumen-datos').html('<p class="text-muted">⚠️ No se está enviando ningún dato</p>');
                }
            }


            // Enviar formulario
            function submitForm() {

                if (!$('#terminos').is(':checked')) {
                    $('#terminos').addClass('is-invalid');
                    return;
                }

                const formData = {
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    tipo_documento: $('#tipo_documento').val(),
                    cedula: $('#cedula').val(),
                    fecha_expedicion: $('#fecha_expedicion').val(),
                    fecha_nacimiento: $('#fecha_nacimiento').val(),
                    email: $('#email').val(),
                    referido_por: $('#referido_por').val(),
                    telefono: $('#telephoneInputmask').val(),
                    pais: $('#pais').val(),
                    departamento: $('#departamento').val(),
                    ciudad: $('#ciudad').val(),
                    direccion: $('#direccion').val(),
                    barrio: $('#barrio').val(),
                    comuna: $('#comuna').val(),
                    ...hiddenFields
                };

                const $btn = $('#final-submit');
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...'
                );

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('users.form') }}",
                    type: "POST",
                    data: {
                        ...formData
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('.wizard-lottie-wrapper').css('display', 'block');
                            $('#msg1').css('display', 'none');
                            $('#msg2').css('display', 'none');
                            $('#redatos, #terminos, #final-submit').hide();
                            $('#wizard-submit-text').text('¡Éxito!');
                            $('#exito').prop('disabled', false).removeAttr('hidden');
                            $('terminos-container').css('display', 'none');
                            abrirEncuestaModal();
                            // Mostrar mensaje de éxito
                            $('#redatos').after(`
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    ${'Formulario enviado con éxito. Revisa tu correo para poder iniciar sesión.'}
                                </div>
                                <a class="btn btn-primary px-5 my-3" href="{{ route('login') }}">Iniciar sesión</a>
                            `);

                        } else {
                            showErrorModal(response.message || 'Error al procesar el formulario.');
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Ocurrió un error al enviar el formulario';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                            if (xhr.responseJSON.errors) {
                                errorMessage += "<ul class='mt-2'>";
                                for (const [field, messages] of Object.entries(xhr.responseJSON
                                        .errors)) {
                                    messages.forEach(msg => {
                                        errorMessage += `<li>${msg}</li>`;
                                    });
                                }
                                errorMessage += "</ul>";
                            }
                        }

                        showErrorModal(errorMessage);
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            }

            // Cargar departamentos
            function loadDepartamentos() {
                const countryGeonameId = $(this).val();

                if (countryGeonameId == colombiaGeonameId) {
                    $('#departamento').prop('disabled', false);
                    $('#ciudad').prop('disabled', true);

                    $.ajax({
                        url: `https://api.afdeveloper.online/api/countries/${colombiaGeonameId}/departments`,
                        method: 'GET',
                        success: function(response) {
                            const states = response;
                            $('#departamento').empty().append(new Option("Seleccione un departamento",
                                ""));

                            states.forEach(state => {
                                const cleanName = state.name.replace(' Department', '');
                                $('#departamento').append(new Option(cleanName, state
                                    .geonameId));
                            });
                        },
                        error: function() {
                            showErrorModal('Error al obtener los departamentos.');
                        }
                    });
                } else {
                    $('#departamento').prop('disabled', true).empty().append(new Option(
                        "Seleccione un país primero", ""));
                    $('#ciudad').prop('disabled', true).empty().append(new Option(
                        "Seleccione un departamento primero", ""));
                }
            }

            // Cargar ciudades
            function loadCiudades() {
                const stateGeonameId = $(this).val();

                if (stateGeonameId) {
                    $('#ciudad').prop('disabled', false);

                    $.ajax({
                        url: `https://api.afdeveloper.online/api/departments/${stateGeonameId}/cities`,
                        method: 'GET',

                        success: function(response) {
                            const cities = response;
                            $('#ciudad').empty().append(new Option("Seleccione una ciudad", ""));

                            cities.forEach(city => {
                                $('#ciudad').append(new Option(city.name, city.geonameId));
                            });
                        },
                        error: function() {
                            showErrorModal('Error al obtener las ciudades.');
                        }
                    });
                } else {
                    $('#ciudad').prop('disabled', true).empty().append(new Option(
                        "Seleccione un departamento primero", ""));
                }
            }

            // Autocompletado de dirección
            function initAutocomplete() {
                if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                    const input = document.getElementById("direccion");
                    const autocomplete = new google.maps.places.Autocomplete(input, {
                        componentRestrictions: {
                            country: "co"
                        },
                        fields: ["formatted_address", "geometry"]
                    });

                    autocomplete.addListener("place_changed", function() {
                        const place = autocomplete.getPlace();
                    });
                }
            }

            // Mostrar modal de error
            function showErrorModal(message) {
                $('#error-message').html(message);
                $('#error-modal').modal('show');
            }

            // Validar email
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Inicializar wizard
            initWizard();


            $('#open2modal').on('click', function() {
                setTimeout(function() {
                    $('#termsModal').modal('hide');
                }, 1000);

            });
        });

        $('#guardarEncuesta').on('click', function() {
            const respuestas = {};

            // Recorremos todos los inputs de las preguntas
            $('#preguntasEncuesta').find('input, textarea, select').each(function() {
                const name = $(this).attr('name');
                if (!name) return;

                // Para radios, solo tomar el seleccionado
                if ($(this).attr('type') === 'radio') {
                    if ($(this).is(':checked')) {
                        respuestas[name] = $(this).val();
                    }
                } else {
                    // Para text, textarea, number, select, etc.
                    respuestas[name] = $(this).val();
                }
            });;

            $.post("{{ route('guardar.question') }}", {
                nombre: $('#name').val(),
                apellido: $('#surname').val(),
                tipo_documento: $('#tipo_documento').val(),
                numero_documento: $('#cedula').val(),
                email: $('#email').val(),
                pais: $('#pais').val(),
                departamento: $('#departamento').val(),
                ciudad: $('#ciudad').val(),
                respuestas: respuestas,
                _token: $('meta[name="csrf-token"]').attr('content')
            }).done(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "¡Gracias por tu tiempo!"
                });

                $('#encuestaModal').modal('hide');
            });
        });

        function abrirEncuestaModal() {
            const dept = $('#departamento').val();
            const city = $('#ciudad').val();

            $.ajax({
                url: "{{ route('questions.byLocation') }}", // la ruta de Laravel
                type: "POST", // POST para evitar caché y permitir CSRF
                data: {
                    department_id: dept,
                    city_id: city,
                    _token: "{{ csrf_token() }}" // importante para Laravel
                },
                dataType: "json",
                success: function(res) {
                    if (res.success && res.questions.length) {
                        renderPreguntas(res.questions);
                        const modal = new bootstrap.Modal(
                            document.getElementById('encuestaModal')
                        );
                        modal.show();
                    } else {
                        console.log("No hay preguntas para esta ubicación");
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    console.log("Error cargando las preguntas");
                }
            });

            function renderPreguntas(questions) {
                let html = '';
                questions.forEach(q => {
                    html += `<div class="mb-3">
                   <label class="form-label fw-bold">${q.question_text}
                     ${q.is_required ? '<span class="text-danger">*</span>' : ''}
                   </label>`;

                    if (q.question_type === 'multiple_choice' && Array.isArray(q.options)) {
                        q.options.forEach((opt, i) => {
                            html += `
                <div class="form-check">
                  <input class="form-check-input" type="radio" 
                         name="q_${q.id}" value="${opt}">
                  <label class="form-check-label">${opt}</label>
                </div>`;
                        });
                    } else if (q.question_type === 'rating') {
                        html +=
                            `<input type="number" class="form-control" name="q_${q.id}" min="1" max="5">`;
                    } else { // text
                        html += `<textarea class="form-control" name="q_${q.id}" rows="2"></textarea>`;
                    }

                    html += '</div>';
                });
                $('#preguntasEncuesta').html(html);
            }
        }



        $('#error-modal').on('hidden.bs.modal', function() {
            document.querySelector('#next-btn')?.focus();
        });

        window.initAutocomplete = function() {
            const input = document.getElementById("direccion");
            if (input) {
                const autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: {
                        country: "co"
                    },
                    fields: ["formatted_address", "geometry"]
                });

                autocomplete.addListener("place_changed", function() {
                    const place = autocomplete.getPlace();
                });
            }
        };
    </script>

    <script>
        $('#wizard .nav-link').on('show.bs.tab', function(e) {
            if (!validateStep(currentStep)) {
                e.preventDefault(); // 🚫 bloquea el cambio automático de tab
                console.log("No puedes avanzar hasta completar este paso");
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.datepicker', {
                locale: 'es',
                dateFormat: 'd/m/Y',
                maxDate: 'today',
                disableMobile: true
            });
        });

        function showInfoModal(message) {
            $('#question-message').html(message);
            $('#question-modal').modal('show');
        }

        $('#cedula').on('change', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            $.ajax({
                url: "{{ route('users.check_cedula') }}",
                type: "POST",
                data: {
                    cedula: this.value,
                    ref_id: "{{ $referencia_id ?? null }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        showInfoModal(
                            '<ul><li>Ya te encuentras registrado(a).</li>  <li>Te has unido exitosamente a la campaña <strong>' +
                            response.campaña + '.</strong></li></ul>');
                        $('#cedula').val('');
                    } else {
                        console.log('Número de documento disponible.');
                    }
                },
                error: function() {
                    console.log('Error al verificar el número de documento.');
                }
            });
        });
    </script>
</body>
