<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        background-color: #b33a3a;
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
        background-color: #b33a3a;
        border-color: #b33a3a;
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
</style>


<body>
    <div class="container my-5">
        <div class="card theme-wizard" id="wizard">
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
                            <p class="text-muted">Ingresa tus datos personales para que sepamos de ti.</p>

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
                                        <option value="cc">Cedula</option>
                                        <option value="ce">Cedula de extranjeria</option>
                                        <option value="nit">Nit</option>
                                        <option value="rut">Rut</option>
                                    </select>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>

                                <!-- Numero de documento -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="cedula">Numero de documento*</label>
                                    <input class="form-control" type="text" name="cedula" id="cedula"
                                        pattern="[0-9]{6,10}" maxlength="10" placeholder="Cédula (6 a 10 dígitos)"
                                        required />
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Correo electrónico -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="email">Correo electronico*</label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="name@example.com" id="email" required />
                                    <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
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
                        </div>
                    </div>

                    <!-- Paso 3: Confirmación -->
                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                        <div class="wizard-lottie-wrapper">
                            <div class="lottie wizard-lottie mx-auto my-3" id="exito" hidden
                                data-options='{"path":"../falcon/public/assets/img/animated-icons/celebration.json"}'>
                            </div>
                        </div>

                        <h4 class="mb-1" id="msg1">¡Revisa tus datos!</h4>
                        <p class="mb-4" id="msg2">Confirma que toda la información sea correcta antes de enviar
                        </p>

                        <div class="text-start mb-4" id="resumen-datos">
                            <!-- Los datos se llenarán con JavaScript -->
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terminos" required>
                            <label class="form-check-label" for="terminos">
                                Acepto los <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#termsModal">términos y condiciones</a>
                            </label>
                            <div class="invalid-feedback">Debes aceptar los términos y condiciones</div>
                        </div>

                        <button class="btn btn-primary px-5 my-3" id="final-submit">Enviar formulario</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {!! Html::script('falcon/public/vendors/lottie/lottie.min.js') !!}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxc1s_F585VkZIt3IFS8eZVMosLrYHtD0&libraries=places&callback=initAutocomplete"
        async defer></script>

    <script>
        $(document).ready(function() {
            const colombiaGeonameId = 3686110;
            let currentStep = 1;
            const totalSteps = 3;

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
                $('#final-submit').on('click', submitForm);

                // Inicializar autocompletado de dirección
                initAutocomplete();

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
                        if (currentStep === totalSteps) {
                            showResumen();
                        }
                        updateNavigation();
                    }
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
                    $('#name, #surname, #tipo_documento, #cedula, #email').each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            isValid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    // Validar email
                    const email = $('#email').val();
                    if (email && !isValidEmail(email)) {
                        $('#email').addClass('is-invalid');
                        isValid = false;
                    }
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
                                    <p class="m-0"><strong><i class="fas fa-phone me-1"></i> Teléfono:</strong> ${$('#telephoneInputmask').val() || 'No proporcionado'}</p>
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
                            </div>
                        </div>
                    </div>
                </div>
            `;

                $('#resumen-datos').html(resumenHTML);
            }



            // Enviar formulario
            function submitForm() {
                if (!validateStep(3)) return;

                if (!$('#terminos').is(':checked')) {
                    $('#terminos').addClass('is-invalid');
                    return;
                }

                const formData = {
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    tipo_documento: $('#tipo_documento').val(),
                    cedula: $('#cedula').val(),
                    email: $('#email').val(),
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
                            $('#resumen-datos, #terminos, #final-submit').hide();
                            $('#wizard-submit-text').text('¡Éxito!');
                            $('#exito').prop('disabled', false).removeAttr('hidden');
                            // Mostrar mensaje de éxito
                            $('#resumen-datos').after(`
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
                        url: 'https://secure.geonames.org/childrenJSON',
                        method: 'GET',
                        data: {
                            geonameId: colombiaGeonameId,
                            username: 'Alan'
                        },
                        success: function(response) {
                            const states = response.geonames;
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
                        url: 'https://secure.geonames.org/childrenJSON',
                        method: 'GET',
                        data: {
                            geonameId: stateGeonameId,
                            username: 'Alan'
                        },
                        success: function(response) {
                            const cities = response.geonames;
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
        });
    </script>
</body>
