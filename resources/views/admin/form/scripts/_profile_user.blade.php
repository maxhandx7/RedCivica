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
                surname: $('#last-name').val(),
                cedula: $('#cedula').val(),
                email: $('#email').val(),
                telefono: $('#telephoneInputmask').val(),
                pais: $('#pais').val(),
                departamento: $('#departamento').val(),
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
                        errorMessage = xhr.responseJSON.message;
                    }
                    showErrorModal(errorMessage);
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        });

        function showErrorModal(message) {
            $('#error-modal .flex-1 p').text(message);
            $('#error-modal').modal('show');
        }
    });
</script>
