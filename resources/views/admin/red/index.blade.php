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
            </div>
        </div>

        {{-- Tabla completa de referidos --}}
        <div class="card shadow-sm">
            <div class="card-header ">
                <h5 class="mb-0">Listado completo de tus referidos</h5>
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
                                <tr>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalUserInfo">
                    ...
                </div>
            </div>
        </div>
    </div>

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
                    label: usuario.name,
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
                    document.getElementById('modalUserInfo').innerHTML = `
                        <p><strong>Nombre:</strong> ${usuario.name}</p>
                        <p><strong>Cédula:</strong> ${usuario.cedula}</p>
                        <p><strong>Nivel:</strong> ${usuario.nivel}</p>
                        <p><strong>Numero de afiliados:</strong> ${usuario.no}</p>
                        `;
                    const modal = new bootstrap.Modal(document.getElementById('userInfoModal'));
                    modal.show();
                }
            });
        });
    </script>
@endsection
@section('scripts')
    {!! Html::script('melody/js/data-table.js') !!}
@endsection
