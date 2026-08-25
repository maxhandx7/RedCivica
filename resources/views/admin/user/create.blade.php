@extends('layouts.admin')
@section('title', 'Nuevo Usuario')
@section('styles')
@endsection
@section('options')
@endsection
@section('preference')
@endsection
@section('content')

    <div class="container mt-5">
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">
                Nuevo usuario
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo usuarios</li>
                </ol>
            </nav>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                @include('admin.user.__form')
                            </div>

                            <a href="{{ route('users.index') }}" class="btn btn-light">
                                Cancelar
                            </a>


                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxc1s_F585VkZIt3IFS8eZVMosLrYHtD0&libraries=places&callback=initAutocomplete"
        async defer></script>

    <script>
        $(function() {

            const colombiaGeonameId = 3686110;

            const $pais = $('#pais');
            const $departamento = $('#departamento');
            const $ciudad = $('#ciudad');

            $pais.on('change', loadDepartamentos);
            $departamento.on('change', loadCiudades);

            function resetSelect($select, message, disabled = true) {
                $select.prop('disabled', disabled)
                    .empty()
                    .append(new Option(message, ""));
            }

            // ==============================
            // CARGAR DEPARTAMENTOS
            // ==============================
            function loadDepartamentos() {

                const countryGeonameId = $pais.val();

                resetSelect($departamento, "Cargando departamentos...", true);
                resetSelect($ciudad, "Seleccione un departamento primero", true);

                if (parseInt(countryGeonameId) !== colombiaGeonameId) {
                    resetSelect($departamento, "Seleccione Colombia", true);
                    return;
                }

                $.ajax({
                    url: `https://api.afdeveloper.com/api/countries/${colombiaGeonameId}/departments`,
                    type: 'GET',
                    dataType: 'json',

                    success: function(states) {

                        if (!states || states.length === 0) {
                            resetSelect($departamento, "No hay departamentos disponibles");
                            return;
                        }

                        $departamento.prop('disabled', false)
                            .empty()
                            .append(new Option("Seleccione un departamento", ""));

                        states.forEach(state => {
                            const cleanName = state.name.replace(' Department', '');
                            $departamento.append(
                                new Option(cleanName, state.geonameId)
                            );
                        });
                    },

                    error: function(xhr) {
                        console.error(xhr.responseText);
                        resetSelect($departamento, "Error al cargar departamentos");
                    }
                });
            }

            // ==============================
            // CARGAR CIUDADES
            // ==============================
            function loadCiudades() {


                const stateGeonameId = $departamento.val();



                resetSelect($ciudad, "Cargando ciudades...", true);

                if (!stateGeonameId) {
                    resetSelect($ciudad, "Seleccione un departamento primero", true);
                    return;
                }


                $.ajax({
                    url: `https://api.afdeveloper.com/api/departments/${stateGeonameId}/cities`,
                    type: 'GET',
                    dataType: 'json',

                    success: function(cities) {

                        if (!cities || cities.length === 0) {
                            resetSelect($ciudad, "No hay ciudades disponibles");
                            return;
                        }

                        $ciudad.prop('disabled', false)
                            .empty()
                            .append(new Option("Seleccione una ciudad", ""));
                        cities.forEach(city => {
                            $ciudad.append(
                                new Option(city.name, city.geonameId)
                            );
                        });
                    },

                    error: function(xhr) {
                        console.error(xhr.responseText);
                        resetSelect($ciudad, "Error al cargar ciudades");
                    }
                });
            }

            // ==============================
            // AUTOCOMPLETE DIRECCIÓN
            // ==============================
            function initAutocomplete() {

                if (typeof google === 'undefined' ||
                    !google.maps ||
                    !google.maps.places) {
                    console.warn("Google Places no está cargado.");
                    return;
                }

                const input = document.getElementById("direccion");
                if (!input) return;

                const autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: {
                        country: "co"
                    },
                    fields: ["formatted_address", "geometry"]
                });

                autocomplete.addListener("place_changed", function() {
                    const place = autocomplete.getPlace();
                    console.log(place);
                });
            }

            // IMPORTANTE: llamar al autocomplete
            initAutocomplete();

        });
    </script>

@endsection
