<script>
    $(document).ready(function() {
        const colombiaGeonameId = 3686110;

        // =====================
        // CARGAR DEPARTAMENTOS
        // =====================
        $('#pais').on('change', function() {
            const countryGeonameId = $(this).val();

            if (countryGeonameId) {
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
                        $('#departamento').empty().append(new Option(
                            "Seleccione un departamento", ""));
                        states.forEach(state => {
                            const cleanName = state.name.replace(' Department', '');
                            $('#departamento').append(new Option(cleanName, state
                                .geonameId));
                        });
                    },
                    error: function() {
                        alert('Error al obtener los departamentos.');
                    }
                });
            } else {
                $('#departamento').prop('disabled', true).empty().append(new Option(
                    "Seleccione un país primero", ""));
                $('#ciudad').prop('disabled', true).empty().append(new Option(
                    "Seleccione un departamento primero", ""));
            }
        });

        // ==================
        // CARGAR CIUDADES
        // ==================
        $('#departamento').on('change', function() {
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
                        $('#ciudad').empty().append(new Option("Seleccione una ciudad",
                            ""));
                        cities.forEach(city => {
                            $('#ciudad').append(new Option(city.name, city
                                .geonameId));
                        });
                    },
                    error: function() {
                        alert('Error al obtener las ciudades.');
                    }
                });
            } else {
                $('#ciudad').prop('disabled', true).empty().append(new Option(
                    "Seleccione un departamento primero", ""));
            }
        });

        // =========================
        // ENVÍO DEL FORMULARIO AJAX
        // =========================
        $('#wizard-submit').on('click', function(e) {
            e.preventDefault();

            let isValid = true;
            $('form').each(function() {
                if (!$(this)[0].checkValidity()) {
                    isValid = false;
                    $(this).addClass('was-validated');
                }
            });

            if (!isValid) return;

            const formData = {
                name: $('#name').val(),
                surname: $('#surname').val(),
                cedula: $('#cedula').val(),
                email: $('#email').val(),
                telefono: $('#telephoneInputmask').val(),
                pais: $('#pais').val(),
                departamento: $('#departamento').val(),
                comuna: $('#comuna').val(),
                ciudad: $('#ciudad').val(),
                direccion: $('#direccion').val(),
                barrio: $('#barrio').val(),
                parent_id: $('#parent_id').val(),
                fuente: $('#fuente').val(),
                medio: $('#medio').val(),
                referencia_id: $('#referencia_id').val(),
            };

            const $btn = $('#login-link');
            const originalHtml = $btn.html();
            $btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...'
            );

            $.ajax({
                url: "{{ route('users.form') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    ...formData
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        //  $('#loading-spinner').prop('disabled', true).prop('hidden', true);
                        $('#exito').prop('disabled', false).removeAttr('hidden');
                    } else {
                        showErrorModal(response.message ||
                            'Error al procesar el formulario.');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Ocurrió un error al enviar el formulario';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message + " " + xhr.responseJSON
                            .errors;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = xhr.responseJSON.message + ":<br>";

                        for (const [field, messages] of Object.entries(xhr.responseJSON
                                .errors)) {
                            messages.forEach(msg => {
                                errorMessage += `• ${msg}<br>`;
                            });
                        }

                        showErrorModal(errorMessage);
                    }
                    showErrorModal(errorMessage);
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        });

        function showErrorModal(message) {
            $('#error-modal .flex-1 p').html(message);
            $('#error-modal').modal('show');
            goToPreviousStep();
        }


        function goToPreviousStep() {
            const $activeTab = $('#wizard .nav-wizard .nav-link.active');
            const $prevTab = $activeTab.closest('li').prev().find('.nav-link');

            if ($prevTab.length) {
                $prevTab.tab('show');
            }
        }

    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxc1s_F585VkZIt3IFS8eZVMosLrYHtD0&libraries=places"></script>
<script>
    function initAutocomplete() {
        const input = document.getElementById("direccion");
        const autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: "co" }, // Colombia
            fields: ["formatted_address", "geometry"]
        });

        autocomplete.addListener("place_changed", function() {
            const place = autocomplete.getPlace();
            console.log("Dirección seleccionada:", place.formatted_address);
            // Si quieres guardar lat/lng también
            // console.log(place.geometry.location.lat(), place.geometry.location.lng());
        });
    }

    document.addEventListener("DOMContentLoaded", initAutocomplete);
</script>
