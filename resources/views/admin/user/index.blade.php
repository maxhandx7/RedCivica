@extends('layouts.admin')
@section('title', 'Gestión de Usuarios')
@section('styles')
    <style>
        .user-table {
            --falcon-table-accent-bg: var(--falcon-table-striped-bg);
            --falcon-table-striped-bg: #f9fafc;
            --falcon-table-hover-bg: #f1f3f9;
        }

        .user-actions {
            white-space: nowrap;
        }

        .empty-state {
            padding: 3rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #d1d7e0;
            margin-bottom: 1rem;
        }

        .search-box {
            max-width: 300px;
        }

        .table-responsive {
            min-height: 300px;
            table-layout: fixed !important;
            overflow-x: auto;
            overflow-y: hidden;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background-color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Gestión de Usuarios</h5>
                </div>

                <div class="col-auto">

                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                            type="button" data-bs-toggle="dropdown" data-boundary="viewport">
                            <span class="fas fa-ellipsis-h fs-11"></span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end border py-2">
                            <!-- Nuevo usuario -->
                            <a href="{{ route('users.create') }}" class="dropdown-item">
                                <i class="fas fa-plus me-1"></i> Nuevo Usuario
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- Exportar usuarios -->
                            <a href="{{ url('/exportar-usuarios') }}" class="dropdown-item">
                                <i class="fas fa-file-export me-1"></i> Exportar
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- Importar usuarios -->
                            <form action="/importar-usuarios" method="POST" enctype="multipart/form-data"
                                class="dropdown-item p-0 px-3">
                                @csrf
                                <label class="form-label mb-1" for="archivo_excel">
                                    <i class="fas fa-file-import me-1"></i> Importar
                                </label>
                                <input type="file" name="archivo_excel" id="archivo_excel"
                                    class="form-control form-control-sm mb-2" required>
                                <button type="submit" class="btn btn-sm btn-primary w-100">Subir</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($users->isEmpty())
                <div class="empty-state m-3">
                    <div class="empty-state-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>No hay usuarios registrados</h4>
                    <p class="text-muted">Comienza agregando nuevos usuarios al sistema.</p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-1"></i> Crear Primer Usuario
                    </a>
                </div>
            @else
                @include('alert.message')
                <div id="users-table" class="table table-responsive scrollbar">
                    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                        <div class="input-group input-group-sm search-box">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Buscar usuarios..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-secondary">Buscar</button>
                        </div>
                    </form>

                    <table class="table table-sm table-hover user-table mb-0 fs--1">
                        <thead class="bg-200 text-800">
                            <tr>
                                <th class="sort" data-sort="id">#</th>
                                <th class="sort" data-sort="cedula">Cédula</th>
                                <th class="sort" data-sort="name">Nombre</th>
                                <th class="sort" data-sort="surname">Apellido</th>
                                <th class="sort" data-sort="email">Email</th>
                                <th class="sort" data-sort="mesa">Mesa</th>
                                <th class="sort" data-sort="created">Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="id">{{ $user->id }}</td>
                                    <td class="cedula">
                                        <a href="{{ route('users.show', $user) }}"
                                            class="fw-semi-bold">{{ $user->cedula }}</a>
                                    </td>
                                    <td class="name">{{ $user->name }}</td>
                                    <td class="surname">{{ $user->surname }}</td>
                                    <td class="email">{{ $user->email }}</td>
                                    <td class="mesa">{{ $user->mesa }}</td>
                                    <td class="created" data-sort="{{ $user->created_at->timestamp }}">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    <td class="user-actions text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-link p-0 me-2"
                                                data-bs-toggle="tooltip" title="Editar">
                                                <span class="text-500 fas fa-edit"></span>
                                            </a>

                                            {!! Form::open(['route' => ['users.destroy', $user], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                            <button type="submit" class="btn btn-link p-0 text-danger"
                                                data-bs-toggle="tooltip" title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                <span class="text-500 fas fa-trash-alt"></span>
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación del lado del servidor (más eficiente) -->
                @if ($users->hasPages())
                    <div class="card-footer bg-light d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('/falcon/public/vendors/sortablejs/Sortable.min.js') !!}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (!$users->isEmpty())
                // Configuración de List.js para búsqueda y ordenamiento
                var options = {
                    valueNames: ['id', 'cedula', 'name', 'surname', 'email', 'mesa', 'created'],
                    page: 15,
                    pagination: true
                };

                var userList = new List('users-table', options);

                // Ordenamiento por columnas
                document.querySelectorAll('.sort').forEach(header => {
                    header.addEventListener('click', () => {
                        const column = header.getAttribute('data-sort');
                        userList.sort(column, {
                            order: header.classList.contains('asc') ? 'desc' : 'asc'
                        });

                        // Actualizar clases de ordenamiento
                        document.querySelectorAll('.sort').forEach(h => h.classList.remove('asc',
                            'desc'));
                        header.classList.add(userList.sorting.order);
                    });
                });

                // Tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            @endif

            // Confirmación de eliminación
            window.confirmDelete = function() {
                return confirm('¿Estás seguro de eliminar este usuario?');
            };
        });
    </script>
@endsection
