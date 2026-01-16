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

            /* ESTILO DE IMPRESIÓN: solo imprimir el QR y centrarlo en la hoja */
            @media print {
                @page {
                    size: A4;
                    /* o 'auto' para dejar al navegador decidir */
                    margin: 20mm;
                    /* ajustar según prefieras */
                }

                /* ocultar todo excepto el QR */
                body * {
                    visibility: hidden;
                }

                #qrCode,
                #qrCode * {
                    visibility: visible;
                }

                /* centrar el QR en la página impresa */
                #qrCode {
                    position: fixed;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    /* Opcional: aumentar tamaño en impresión */
                    width: 120mm;
                    /* tamaño impreso aproximado */
                    height: 120mm;
                    border: none;
                    box-shadow: none;
                    background: white;
                    padding: 0;
                }
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
                                                                {{-- onclick="shareReference()" --}} data-bs-toggle="modal"
                                                                data-bs-target="#userInfoModal"><i
                                                                    class="fas fa-user-plus"></i>
                                                                Invitar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="pt-3">
                                        <div class="text-center" id="qrCode">
                                        </div>
                                    </div>
                                    <div class="pt-3">
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
                                        <div class="icon-xxl bg-primary-soft text-primary rounded-circle mb-3 mx-auto">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h2 class="display-4 fw-bold text-primary mb-2">{{ $referidosTotales ?? 0 }}</h2>
                                        <p class="text-muted mb-4">Personas en tu red</p>
                                    </div>
                                    <a href="{{ route('red.index') }}" class="btn btn-primary mt-auto">
                                        <i class="fas fa-network-wired "> </i> Explorar red completa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="userInfoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Campañas para compartir</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modalUserInfo">
                                <div class="table-responsive  pt-3">
                                    <table id="order-listing"
                                        class="table table-sm table-striped table-hover align-middle mb-0 fs-12">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;">Campaña</th>
                                                <th style="width: 40%;">Objetivo</th>
                                                <th style="width: 20%;" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($referencias as $ref)
                                                <tr>
                                                    <td>{{ $ref->campaña->name }}</td>
                                                    <td>{{ $ref->objetivo }}</td>

                                                    <td style="width: 200px;" class="text-center">
                                                        {!! Form::open([
                                                            'route' => ['referencias.destroy', $ref],
                                                            'method' => 'DELETE',
                                                            'id' => 'delete-form-' . $ref->id,
                                                        ]) !!}

                                                        <a class="btn btn-outline-info btn-sm d-inline-flex align-items-center show-reference-btn"
                                                            data-bs-toggle="modal" data-bs-target="#referenceModal"
                                                            data-reference-id="{{ $ref->id }}"
                                                            data-campaign="{{ $ref->campaña->name }}"
                                                            data-objective="{{ $ref->objetivo }}"
                                                            data-source="{{ $ref->fuente }}"
                                                            data-medium="{{ $ref->medio }}"
                                                            data-created="{{ $ref->created_at->translatedFormat('d/m/Y H:i') }}"
                                                            data-referral-url="{{ route('referidos.registro', [
                                                                'usr' => auth()->id(),
                                                                'fuente' => $ref->fuente,
                                                                'medio' => $ref->medio,
                                                                'ref_id' => $ref->id,
                                                            ]) }}"
                                                            title="Compartir campaña">

                                                            <i class="fas fa-link me-1"></i>
                                                           Click aqui para compartir
                                                        </a>

                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                            @empty
                                                <div class="text-center py-4">
                                                    <img class="img-fluid mb-3"
                                                        src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}"
                                                        alt="No data" style="max-width: 200px;">
                                                    <h5>No hay campañas publicadas</h5>
                                                    <p class="mb-0">Parece que no hay datos disponibles todavía</p>
                                                </div>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.referencia.__modal_referencia')


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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        {!! Html::script('/falcon/public/vendors/chart/chart.umd.js') !!}
        {!! Html::script('/js/chart.js') !!}
        {!! Html::script('/js/leaflet.js') !!}

        <script>
            document.addEventListener('DOMContentLoaded', async () => {

                /* =======================
                   CHARTS
                ======================= */

                const crearGrafico = (id, config) => {
                    const canvas = document.getElementById(id);
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    new Chart(ctx, config);
                };

                // Usuarios registrados por fecha
                crearGrafico('usersChart', {
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

                // Usuarios por ciudad
                crearGrafico('ciudadChart', {
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

                /* =======================
                   FETCH USERS BY DEPARTMENT
                ======================= */

                try {
                    const response = await fetch("{{ url('/users-by-department') }}");
                    const data = await response.json();

                    // Chart departamentos
                    crearGrafico('chart', {
                        type: 'bar',
                        data: {
                            labels: data.map(d => d.name),
                            datasets: [{
                                label: 'Usuarios',
                                data: data.map(d => d.users),
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
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

                    /* =======================
                       MAPA LEAFLET
                    ======================= */

                    const mapContainer = document.getElementById('map');
                    if (!mapContainer) return;

                    const map = L.map('map').setView([4.5709, -74.2973], 5);

                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; OSM & CARTO',
                        subdomains: 'abcd',
                        maxZoom: 18
                    }).addTo(map);

                    const getColor = (value) =>
                        value > 1200 ? '#800026' :
                        value > 800 ? '#BD0026' :
                        value > 400 ? '#E31A1C' :
                        value > 100 ? '#FC4E2A' :
                        '#FFEDA0';

                    data.forEach(dep => {
                        if (dep.users > 0 && dep.lat && dep.lng) {
                            L.circleMarker([dep.lat, dep.lng], {
                                    radius: Math.min(40, 5 + dep.users / 10),
                                    fillColor: getColor(dep.users),
                                    color: '#000',
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.6
                                })
                                .bindPopup(`<b>${dep.name}</b><br>Usuarios: ${dep.users}`)
                                .addTo(map);
                        }
                    });

                } catch (error) {
                    console.error('Error cargando datos:', error);
                }

            });

            /* =======================
               SHARE REFERENCE
            ======================= */

            window.shareReference = function() {

                const userId = {{ auth()->check() ? auth()->id() : 'null' }};
                const refId = {{ $ref_id }};
                const baseUrl = window.location.origin;

                if (userId === null) {
                    alert('Por favor inicia sesión para continuar');
                    return;
                }

                const link = `${baseUrl}/referidos/registro?usr=${userId}&ref_id=${refId}`;

                navigator.clipboard.writeText(link).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Enlace copiado',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });

                const qrContainer = document.getElementById('qrCode');
                if (qrContainer) {
                    qrContainer.innerHTML = '';
                    new QRCode(qrContainer, {
                        text: link,
                        width: 150,
                        height: 150,
                        colorDark: '#900000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }

                if (navigator.share) {
                    navigator.share({
                        title: 'Únete a PoliticFriends',
                        text: 'Regístrate con este enlace y gana puntos.',
                        url: link
                    }).catch(() => {});
                }
            };
        </script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Variables para almacenar datos
                let currentReferenceUrl = '';
                let qrCodeInstance = null;

                // Evento cuando se muestra el modal
                document.querySelectorAll('.show-reference-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        // Obtener datos de los atributos data
                        const referenceId = this.getAttribute('data-reference-id');
                        const campaign = this.getAttribute('data-campaign');
                        const objective = this.getAttribute('data-objective');
                        const source = this.getAttribute('data-source');
                        const medium = this.getAttribute('data-medium');
                        const created = this.getAttribute('data-created');
                        currentReferenceUrl = this.getAttribute('data-referral-url');

                        // Actualizar contenido del modal
                        document.getElementById('modalCampaign').textContent = campaign;
                        document.getElementById('modalObjective').textContent = objective;
                        document.getElementById('modalSource').textContent = source;
                        document.getElementById('modalMedium').textContent = medium;
                        document.getElementById('modalCreated').textContent = created;
                        document.getElementById('referenceLinkInput').value = currentReferenceUrl;

                        // Generar o actualizar QR
                        if (qrCodeInstance) {
                            qrCodeInstance.clear();
                            qrCodeInstance.makeCode(currentReferenceUrl);
                        } else {
                            qrCodeInstance = new QRCode(document.getElementById("qrCodeContainer"), {
                                text: currentReferenceUrl,
                                width: 150,
                                height: 150,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        }
                    });
                });

                // Función para copiar el enlace
                window.copyReferenceLink = function() {
                    const copyText = document.getElementById("referenceLinkInput");
                    copyText.select();
                    document.execCommand("copy");

                    // Mostrar notificación
                    const originalText = copyText.nextElementSibling.innerHTML;
                    copyText.nextElementSibling.innerHTML = '<i class="fas fa-check"></i> Copiado';

                    setTimeout(() => {
                        copyText.nextElementSibling.innerHTML = originalText;
                    }, 2000);
                };

                // Función para abrir el formulario
                window.openReferralForm = function() {
                    window.open(currentReferenceUrl, '_blank');
                };

                // Función para compartir
                window.shareReference = function() {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Únete a nuestra campaña',
                            text: 'Por favor regístrate usando este enlace de campaña',
                            url: currentReferenceUrl
                        }).catch(err => {
                            console.log('Error al compartir:', err);
                        });
                    } else {
                        // Fallback para navegadores que no soportan Web Share API
                        copyReferenceLink();
                        toast.show();

                    }
                };
            });
        </script>
