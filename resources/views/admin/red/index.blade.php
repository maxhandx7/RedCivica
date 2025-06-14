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


    <div class="container mt-4">
        <h1 class="mb-4">Estructura de Mi Red</h1>



        @include('alert.message')
        <div class="table-responsive">
            <table id="order-listing" class="table">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 sort text-nowrap">ID</th>
                        <th class="text-900 sort text-nowrap">Usuario</th>
                        <th class="text-900 sort text-nowrap">Cedula</th>
                        <th class="text-900 sort text-nowrap">Email</th>
                        <th class="text-900 sort text-nowrap">Nivel</th>
                        <th class="text-900 sort text-nowrap text-end">Registrado</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($referidos as $nivel => $usuario)
                        <tr>
                            <td> {{ $usuario->id }} </td>
                            <td> {{ $usuario->name }} </td>
                            <td> {{ $usuario->cedula }} </td>
                            <td> {{ $usuario->email }} </td>
                            <td> {{ $usuario->depth }} </td>
                            <td class="text-end"> {{ $usuario->formatted_date }} </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Visualización de tu red</h5>
            <div class="position-relative" style="height: 500px;" id="networkContainer">
                <canvas id="networkCanvas" style="width: 100%; height: 100%; display: block;"></canvas>
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

            nodes.push({
                id: authUserId,
                label: "Tú",
                color: '#3b82f6',
                shape: 'dot',
                size: 30
            });

            data.forEach(usuario => {
                if (!usuario.parent_id) return;
                const nivel = usuario.nivel || 0;

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
