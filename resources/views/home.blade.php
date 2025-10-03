    @extends('layouts.admin')

    @section('title', 'PoliticFriends – Dashboard')

    {!! Html::style('/css/leaflet.css') !!}

    @section('content')

        <style>
            #map {
                height: 500px;
                margin-bottom: 20px;
            }

            canvas {
                max-width: 600px;
                margin: auto;
            }
        </style>

        <div class="container py-4">
            @hasrole('admin')
                <!-- INTERFAZ ADMINISTRADOR -->
                <div class="admin-dashboard">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tarjeta 1: Referidos Totales -->
                                <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                                    <div class="d-flex flex-between-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                                <span class="fs-11 fas fa-users text-primary"></span>
                                            </div>
                                            <h6 class="mb-0">Referidos Totales</h6>
                                        </div>
                                        <div class="dropdown font-sans-serif btn-reveal-trigger">
                                            <button
                                                class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                                <span class="fas fa-ellipsis-h fs-11"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border py-2">
                                                <a class="dropdown-item" href="{{ route('referencias.index') }}">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $referidosTotales ?? 0 }}</p>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="me-1 fas fa-caret-{{ $referidosTotales > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                                <p class="fs-11 mb-0 text-nowrap">Personas registradas en tu red</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 2: Probabilidad de votación -->
                                <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                                    <div class="d-flex flex-between-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                                <span class="fs-11 fas fa-vote-yea text-primary"></span>
                                            </div>
                                            <h6 class="mb-0">Probabilidad de votación</h6>
                                        </div>
                                        <div class="dropdown font-sans-serif btn-reveal-trigger">
                                            <button
                                                class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                                <span class="fas fa-ellipsis-h fs-11"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border py-2">
                                                <a class="dropdown-item" href="{{ route('analitica.index') }}">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $probabilidadVoto ?? 80 }}%</p>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="me-1 fas fa-caret-{{ $probabilidadVoto > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                                <p class="fs-11 mb-0 text-nowrap">Estimado de participación</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 3: Partidarios activos -->
                                <div class="col-lg-4">
                                    <div class="d-flex flex-between-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2">
                                                <span class="fs-11 fas fa-hands-helping text-primary"></span>
                                            </div>
                                            <h6 class="mb-0">Partidarios activos</h6>
                                        </div>
                                        <div class="dropdown font-sans-serif btn-reveal-trigger">
                                            <button
                                                class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                                type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                                <span class="fas fa-ellipsis-h fs-11"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border py-2">
                                                <a class="dropdown-item" href="{{ route('red.index') }}">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $partidariosActivos ?? 0 }}</p>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="me-1 fas fa-caret-{{ $partidariosActivos > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                                <p class="fs-11 mb-0 text-nowrap">Usuarios con referidos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('alert.message')

                    <div class="row">
                        <div class="col-lg-6 border-end-lg">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    |<i class="fas fa-chart-bar me-2"></i>Usuarios Registrados por Mes
                                </div>

                                <div class="card-body text-center d-flex flex-column">
                                    <p class="text-muted">Visualiza la cantidad de usuarios que se han registrado en la
                                        plataforma cada
                                        mes.</p>
                                    <div class="my-auto">
                                        <canvas id="usersChart" width="1618" height="1000"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 border-end-lg">
                            <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                |<i class="fas fa-chart-pie me-2"></i>Usuarios por Ciudad
                            </div>

                            <div class="card-body text-center d-flex flex-column">
                                <p class="text-muted">Visualiza la distribución de usuarios en tu red según su ciudad.
                                </p>
                                <div class="my-auto">
                                    <canvas id="ciudadChart" width="1618" height="1000"></canvas>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    |<i class="fas fa-chart-pie me-2"></i>Usuarios por Departamento
                                </div>

                                <div class="card-body text-center d-flex flex-column">
                                    <p class="text-muted">Visualiza la distribución de usuarios en tu red según su departamento.
                                    </p>
                                    <div id="map"></div>
                                    <canvas id="chart"></canvas>
                                </div>
                            </div>
                    </div>
                </div>
            @endhasrole

            @hasrole('cliente')
                <div class="client-dashboard">
                    @include('alert.message')
                    <!-- Primera fila: Red de Referidos + Acciones Rápidas -->
                    <div class="row mb-4">
                        <!-- Columna 1: Red de Referidos -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white py-3">
                                    <p class="mb-0"><i class="fas fa-bolt me-2"></i>Panel para compartir</p>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-grid gap-3">
                                        <div class="settings my-3">
                                            <div class="card shadow-none">
                                                <div class="card-body alert mb-0" role="alert">
                                                    <div class="btn-close-/falcon-container">
                                                        <button class="btn btn-link btn-close-/falcon p-0" aria-label="Close"
                                                            data-bs-dismiss="alert"></button>
                                                    </div>
                                                    <div class="text-center"><img
                                                            src="/falcon/public/assets/img/icons/spot-illustrations/navbar-vertical.png"
                                                            alt="" width="80" />
                                                        <p class="fs-11 mt-2">Invita a personas a tu red
                                                        <div class="d-grid"><button class="btn btn-sm btn-primary"
                                                                onclick="shareReference()"><i class="fas fa-user-plus"></i>
                                                                Invitar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-auto pt-3">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>Gana puntos por cada referido que se una</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2: Acciones Rápidas -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white py-3">
                                    <p class="mb-0"><i class="fas fa-network-wired me-2"></i>Mi Red de Referidos</p>
                                </div>
                                <div class="card-body text-center d-flex flex-column">
                                    <div class="my-auto">
                                        <div class="icon-xxl bg-success-soft text-success rounded-circle mb-3 mx-auto">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h2 class="display-4 fw-bold text-primary mb-2">{{ $referidosTotales ?? 0 }}</h2>
                                        <p class="text-muted mb-4">Personas en tu red</p>
                                    </div>
                                    <a href="{{ route('red.index') }}" class="btn btn-success mt-auto">
                                        <i class="fas fa-network-wired "> </i> Explorar red completa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: Noticias Políticas (full width) -->
                    @if ($noticias && count($noticias))
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary text-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Noticias Políticas</h5>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($noticias as $n)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100 border-0 hover-shadow">
                                                <div class="card-body">
                                                    <span class="badge bg-info mb-2">{{ $n['source'] }}</span>
                                                    <h6 class="card-title">
                                                        <a href="{{ $n['url'] }}" target="_blank"
                                                            class="text-dark stretched-link">{{ $n['title'] }}</a>
                                                    </h6>
                                                    <p class="card-text small text-muted">
                                                        {{ Str::limit($n['description'], 120) }}
                                                    </p>
                                                </div>
                                                <div class="card-footer bg-transparent border-0 pt-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">
                                                            <i class="far fa-clock me-1"></i>
                                                            {{ \Carbon\Carbon::parse($n['published_at'])->diffForHumans() }}
                                                        </small>
                                                        <a href="{{ $n['url'] }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Leer <i class="fas fa-external-link-alt ms-1"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


            @endhasrole

        @endsection

        @section('styles')
            <style>
                .icon-xl {
                    width: 60px;
                    height: 60px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.5rem;
                }

                .client-dashboard .card {
                    border-radius: 0.5rem;
                    overflow: hidden;
                }

                .client-dashboard .card-header {
                    padding: 1rem 1.5rem;
                }
            </style>
        @endsection

        {!! Html::script('/falcon/public/vendors/chart/chart.umd.js') !!}
        {!! Html::script('/js/chart.js') !!}
        {!! Html::script('/js/leaflet.js') !!}

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('usersChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labelsDate),
                        datasets: [{
                            label: 'Usuarios registrados',
                            data: @json($totalsDate),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                /*   const ctxdep = document.getElementById('departmentsChart').getContext('2d');
                                new Chart(ctxdep, {
                                    type: 'doughnut',
                                    data: {
                                        labels: @json($labelsDep),
                                        datasets: [{
                                            label: 'Usuarios por departamento',
                                            data: @json($totalsDep),
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)',
                                            ]
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'right'
                                            }
                                        }
                                    }
                                });
                 */

                const ctxciudad = document.getElementById('ciudadChart').getContext('2d');
                new Chart(ctxciudad, {
                    type: 'doughnut',
                    data: {
                        labels: @json($labelsCity),
                        datasets: [{
                            label: 'Usuarios por ciudad',
                            data: @json($totalsCity),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });

            });

            let link = 'https://politicfriends.com/referidos/registro?usr=1&fuente=Whatsapp&ref_id=4';


            window.shareReference = function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Únete a nuestra red en PoliticFriends',
                        text: 'Por favor regístrate usando este enlace para que ambos ganemos puntos en PoliticFriends.',
                        url: link,
                    }).catch(err => {
                        console.log('Error al compartir:', err);
                    });
                } else {
                    // Fallback para navegadores que no soportan Web Share API
                    copyReferenceLink();

                }

                window.copyReferenceLink = function() {
                    const copyText = link;
                    copyText.select();
                    document.execCommand("copy");

                    // Mostrar notificación
                    const originalText = copyText.nextElementSibling.innerHTML;
                    copyText.nextElementSibling.innerHTML = '<i class="fas fa-check"></i> Copiado';

                    setTimeout(() => {
                        copyText.nextElementSibling.innerHTML = originalText;
                    }, 2000);
                };
            };
        </script>


<script>
document.addEventListener("DOMContentLoaded", async () => {
    const response = await fetch("{{ url('/users-by-department') }}");
    const data = await response.json();

    // --- Gráfico con Chart.js ---
    const ctx = document.getElementById("chart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.map(d => d.name),
            datasets: [{
                label: "Usuarios",
                data: data.map(d => d.users),
                backgroundColor: "rgba(75, 192, 192, 0.6)"
            }]
        }
    });

   // Inicializar mapa
        var map = L.map('map').setView([4.5709, -74.2973], 6);

        // Capa base con CARTO
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 10
        }).addTo(map);

        
        function getColor(value) {
            console.log(value);
            return value > 1200 ? '#800026' :
                   value > 800  ? '#BD0026' :
                   value > 400  ? '#E31A1C' :
                   value > 100  ? '#FC4E2A' :
                                  '#FFEDA0';
        }

    // Pintamos marcadores con lat/lng de cada departamento
    data.forEach(dep => {
        if (dep.users > 0) {
            L.circleMarker([dep.lat, dep.lng], {
                radius: 5 + dep.users, // el tamaño crece con la cantidad
                fillColor: dep.users > 0 ? getColor(dep.users) : 'gray',
                color: "#000",
                weight: 1,
                opacity: 1,
                fillOpacity: 0.6
            }).bindPopup(`<b>${dep.name}</b><br>Usuarios: ${dep.users}`).addTo(map);
        }
    });
});
</script>
