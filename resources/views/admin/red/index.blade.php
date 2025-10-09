@extends('layouts.admin')
@section('styles')
@endsection
@section('options')
@endsection
@section('preference')
@endsection
@section('content')
    {!! Html::style('/falcon/public/assets/css/vis-network.css') !!}
    {!! Html::style('/falcon/public/vendors/jquery/jquery.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net/dataTables.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js') !!}


    <style>
        .modal-content {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .modal-header {
            background-color: var(--falcon-primary);
            border-bottom: none;
            border-radius: 0.5rem 0.5rem 0 0;
            padding: 1.25rem 1.5rem;
        }

        .modal-header h5 {
            color: white;
            margin: 0;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }



        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
            background-color: white;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--falcon-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--falcon-dark);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .user-id {
            color: var(--falcon-gray);
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .info-section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--falcon-primary);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--falcon-gray-light);
        }

        .info-row {
            display: flex;
            margin-bottom: 0.75rem;
        }

        .info-label {
            flex: 0 0 40%;
            font-weight: 500;
            color: var(--falcon-secondary);
        }

        .info-value {
            flex: 0 0 60%;
            color: var(--falcon-dark);
        }

        .badge-nivel {
            background-color: var(--falcon-primary);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-afiliados {
            background-color: var(--falcon-success);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .modal-footer {
            border-top: 1px solid var(--falcon-gray-light);
            padding: 1rem 1.5rem;
            background-color: var(--falcon-light);
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .btn-falcon-primary {
            background-color: var(--falcon-primary);
            border-color: var(--falcon-primary);
            color: white;
        }

        .btn-falcon-primary:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>

    <div class="container mt-5">
        {{-- Título --}}
        <div class="mb-4 page-title text-center">
            <h2 class="fw-bold text-primary">Estructura de Mi Red</h2>
            @include('alert.message')
        </div>

        {{-- Visualización y líderes --}}
        <div class="row g-4 mb-5">
            {{-- Red visual --}}
            <div class="col-lg-6">
                <div class="card shadow-sm h-auto">
                    <div class="card-header ">
                        <h5 class="mb-0">Visualización de mi red</h5>
                    </div>
                    <div class="card-body">
                        <div class="position-relative" style="height: 500px;" id="networkContainer">
                            <canvas id="networkCanvas" style="width: 100%; height: 100%; display: block;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top líderes --}}
            <div class="col-lg-6">
                <div class="card shadow-sm h-auto">
                    @if ($topReferidores->count() > 0)
                        <div class="card-header  d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Principales líderes en referencias</h5>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-sm table-hover mb-0">
                                <thead class=" text-600">
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th class="text-end">Afiliados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topReferidores as $index => $usuario)
                                        <tr>
                                            <td>
                                                @if ($index === 0)
                                                    <span class="fas fa-crown text-primary"></span>
                                                @elseif ($index === 1)
                                                    <span class="fas fa-medal text-secondary"></span>
                                                @elseif ($index === 2)
                                                    <span class="fas fa-trophy text-warning"></span>
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>{{ $usuario->cedula }}</td>
                                            <td>{{ $usuario->name }}</td>
                                            <td class="text-end text-primary fw-bold">+{{ $usuario->children_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer  text-center">
                            <a href="#" class="fs--1 fw-semi-bold text-decoration-none">Ver la clasificación completa
                                →</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img class="img-fluid mb-3" src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}"
                                alt="No data" style="max-width: 200px;">
                            <h5>No tienes referidos</h5>
                            <p class="mb-0">Parece que no hay datos disponibles todavía</p>
                        </div>
                    @endif
                </div>

                <div class="card h-50 mt-3 mb-7">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0">Mis Necesidades</h6>
                    </div>
                    <div class="card-body p-0 overflow-hidden">

                        @forelse($needs as $need)
                            <div
                                class="d-flex justify-content-between hover-actions-trigger btn-reveal-trigger px-x1 hover-bg-100 ">
                                <div class="form-check mb-0 d-flex align-items-center ">
                                    <input class="form-check-input rounded-3 form-check-line-through p-2 mt-0"
                                        type="checkbox" id="need-{{ $need->id }}"
                                        {{ $need->estado == 'resuelta' ? 'disabled' : ($need->estado == 'en proceso' ? 'disabled' : '') }}
                                        {{ $need->is_completed() ? 'checked' : '' }}
                                        onchange="toggleNeedCompleted({{ $need->id }}, this.checked)">
                                    <label class="form-check-label mb-0 p-3" for="need-{{ $need->id }}">
                                        {{ $need->titulo }} - {{ Str::limit($need->descripcion, 60) }}
                                    </label>
                                    <span
                                        class="badge bg-{{ $need->estado == 'resuelta' ? 'success' : ($need->estado == 'en proceso' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($need->estado) }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                                        <button
                                            class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal-sm transition-none"
                                            type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div
                                            class="dropdown-menu dropdown-menu-end border py-2 {{ $need->estado == 'resuelta' ? 'd-none' : ($need->estado == 'en proceso' ? 'd-none' : '') }}">
                                            <a class="dropdown-item text-danger" href="#"
                                                onclick="deleteNeed({{ $need->id }})">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted">No tienes necesidades registradas. ¡Agrega una nueva!
                            </div>
                        @endforelse
                    </div>
                    <div class="card-footer bg-body-tertiary p-0">
                        <button class="btn btn-sm btn-link d-block py-2" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="fas fa-plus me-1 fs-11"></i>Agregar nueva necesidad
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Tabla completa de referidos --}}
        <div class="card shadow-sm">
            <div class="card-header ">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Listado completo de tus referidos</h5>
                    </div>

                    <div class="col-auto">

                        <div class="dropdown font-sans-serif btn-reveal-trigger">
                            <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                                <span class="fas fa-ellipsis-h fs-11"></span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end border py-2">


                                <!-- Exportar usuarios -->
                                <a href="{{ url('/exportar-clientes') }}" class="dropdown-item">
                                    <i class="fas fa-file-export me-1"></i> Exportar
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="order-listing" class="table table-striped mb-0">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th class="text-end">Nivel</th>
                                <th class="text-end">Registrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referidos as $nivel => $usuario)
                                <tr onclick="mostrarUsuario({{ $usuario->id }})" style="cursor:pointer;">
                                    <td>{{ $usuario->cedula }}</td>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->surname }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td class="text-end">N - {{ $usuario->depth }}</td>
                                    <td class="text-end">{{ $usuario->formatted_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="userInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Información del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalUserInfo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('needs.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Registrar necesidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-primary text-white"><strong class="me-auto">PoliticFriends</strong><small>11
                        mins
                        ago</small>
                    <div data-bs-theme="dark">
                        <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                <div class="toast-body">Enlace copiado al portapapeles. Puedes compartirlo manualmente.</div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                let mensaje = @json(session('success'));
                $('#toast-body').text(mensaje);
            });
        </script>
    @endif

    {!! Html::script('/falcon/public/assets/js/vis-network.min.js') !!}


    <script>
        let network;

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('networkContainer');
            const data = @json($networkData ?? []);
            const nodes = [];
            const edges = [];

            const authUserId = '{{ (string) auth()->id() }}';

            const addedIds = new Set();

            function mostrarUsuario(userId) {
                
                const usuario = data.find(u => u.id == userId);

                if (!usuario) {
                    console.warn(`No se encontró el usuario con ID ${userId}`);
                    return;
                }
                
                if (usuario.id === authUserId) {
                    return;
                }

                if (usuario) {
                    document.getElementById('modalUserInfo').innerHTML = generateUserInfo(usuario);
                    const modal = new bootstrap.Modal(document.getElementById('userInfoModal'));
                    modal.show();
                }
            }

            nodes.push({
                id: authUserId,
                label: "Tú",
                color: '#3b82f6',
                shape: 'dot',
                size: 30
            });

            addedIds.add(authUserId);

            data.forEach(usuario => {
                if (!usuario.parent_id) return;
                const nivel = usuario.nivel || 0;

                if (addedIds.has(usuario.id)) {
                    console.warn(`ID duplicado omitido: ${usuario.id}`);
                    return;
                }

                let color = '#10b981'; // verde
                if (nivel == 2) color = '#a855f7'; // púrpura
                if (nivel >= 3) color = '#f59e0b';



                nodes.push({
                    id: usuario.id,
                    label: usuario.name + " " + usuario.surname,
                    color: color,
                    shape: 'dot',
                    size: 12
                });

                addedIds.add(usuario.id);

                edges.push({
                    from: String(usuario.parent_id),
                    to: String(usuario.id),
                    color: 'rgba(255,0,0,0.8)',
                });
            });

            const options = {
                layout: {
                    hierarchical: false
                },
                physics: {
                    enabled: true,
                    stabilization: {
                        iterations: 200,
                        fit: true
                    },
                    solver: "forceAtlas2Based",
                    forceAtlas2Based: {
                        gravitationalConstant: -50,
                        centralGravity: 0.005,
                        springLength: 100,
                        springConstant: 0.08,
                        avoidOverlap: 1
                    }
                },
                edges: {
                    color: '#cccccc',
                    arrows: {
                        to: {
                            enabled: false
                        }
                    },
                    smooth: {
                        enabled: true,
                        type: "continuous"
                    }
                },
                nodes: {
                    shape: "dot",
                    size: 16,
                    font: {
                        size: 12,
                        color: "#000"
                    }
                }
            };

            network = new vis.Network(container, {
                nodes: new vis.DataSet(nodes),
                edges: new vis.DataSet(edges)
            }, options);

            network.on("click", function(params) {

                if (params.nodes.length === 0) return;

                const nodeId = params.nodes[0];
                const usuario = data.find(u => u.id === nodeId);

                if (usuario) {
                    document.getElementById('modalUserInfo').innerHTML = generateUserInfo(usuario);
                    const modal = new bootstrap.Modal(document.getElementById('userInfoModal'));
                    modal.show();
                }
            });



            function generateUserInfo(usuario) {
                // Generar iniciales para el avatar
                const initials = (usuario.name.charAt(0) + usuario.surname.charAt(0)).toUpperCase();

                return `
                <div class="user-avatar">
                    ${initials}
                </div>
                <div class="user-name">${usuario.name} ${usuario.surname}</div>
                <div class="user-id">ID: ${usuario.id}</div>
                
                <div class="info-section">
                    <div class="section-title"><i class="fas fa-id-card me-2"></i>Información Personal</div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">${usuario.email || 'No especificada'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tipo Documento:</div>
                        <div class="info-value">${usuario.tipo_documento}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Cédula:</div>
                        <div class="info-value">${usuario.cedula}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Fecha Nacimiento:</div>
                        <div class="info-value">${usuario.fecha_nacimiento || 'No especificada'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Fecha Expedición:</div>
                        <div class="info-value">${usuario.fecha_expedicion || 'No especificada'}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <div class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Ubicación</div>
                    <div class="info-row">
                        <div class="info-label">Dirección:</div>
                        <div class="info-value">${usuario.direccion || 'No especificada'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Barrio:</div>
                        <div class="info-value">${usuario.barrio || 'No especificado'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Ciudad:</div>
                        <div class="info-value">${usuario.ciudad || 'No especificada'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Departamento:</div>
                        <div class="info-value">${usuario.departamento || 'No especificado'}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Mesa:</div>
                        <div class="info-value">${usuario.mesa || 'No asignada'}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <div class="section-title"><i class="fas fa-phone me-2"></i>Contacto</div>
                    <div class="info-row">
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">${usuario.telefono || 'No especificado'}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <div class="section-title"><i class="fas fa-chart-line me-2"></i>Información de Red</div>
                    <div class="info-row">
                        <div class="info-label">Nivel:</div>
                        <div class="info-value"><span class="badge-nivel">${usuario.nivel}</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Número de Afiliados:</div>
                        <div class="info-value"><span class="badge-afiliados">${usuario.no}</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Fecha de Registro:</div>
                        <div class="info-value">${usuario.created_at}</div>
                    </div>
                     <div class="info-row">
                        <div class="info-label">Nombre Padre:</div>
                        <div class="info-value">${usuario.nombre_padre || 'Sin padre'}</div>
                    </div>
                   
                </div>
            `;
            }

            window.mostrarUsuario = mostrarUsuario;
        });
    </script>

    <script>
        function deleteNeed(id) {
            if (!confirm("¿Eliminar esta necesidad?")) return;
            fetch(`/needs/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        }
    </script>

@endsection
@section('scripts')
    {!! Html::script('melody/js/data-table.js') !!}
@endsection
