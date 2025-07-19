@extends('layouts.admin') {{-- Asegúrate de tener un layout base con Bootstrap y auth --}}

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Mis Necesidades</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-1"></i> Nueva necesidad
        </button>
    </div>

    {{-- Tabla de necesidades --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 table-hover align-middle">
                    <thead class="table">
                        <tr>
                            <th>Referido</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($needs as $need)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $need->registrado_por) }}" class="text-decoration-none">
                                    {{ $need->registradoPor->name ?? 'Desconocido' }}
                                </a>
                            <td>{{ $need->titulo }}</td>
                            <td>{{ Str::limit($need->descripcion, 60) }}</td>
                            <td>
                                <span class="badge bg-{{ $need->estado == 'resuelta' ? 'success' : ($need->estado == 'en proceso' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($need->estado) }}
                                </span>
                            </td>
                            <td>{{ $need->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info me-1" 
                                        onclick="editNeed({{ $need->id }}, '{{ $need->titulo }}', `{{ $need->descripcion }}`, '{{ $need->estado }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('needs.destroy', $need->id) }}" class="d-inline-block"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta necesidad?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No tienes necesidades registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal para crear necesidad --}}
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
                    <label for="referido_id" class="form-label">Referido</label>
                    <input type="number" class="form-control" name="referido_id" required>
                </div>
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



{{-- Modal para editar necesidad --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editForm" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar necesidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label for="edit_titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="edit_descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_estado" class="form-label">Estado</label>
                    <select class="form-select" id="edit_estado" name="estado">
                        <option value="pendiente">Pendiente</option>
                        <option value="en proceso">En proceso</option>
                        <option value="resuelta">Resuelta</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editNeed(id, titulo, descripcion, estado) {
        const form = document.getElementById('editForm');
        form.action = `/needs/${id}`;
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_titulo').value = titulo;
        document.getElementById('edit_descripcion').value = descripcion;
        document.getElementById('edit_estado').value = estado;
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    }
</script>
@endsection
