@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 font-weight-bold text-gray-800">
            <i class="fas fa-check text-primary"></i> Respuestas Recibidas
        </h2>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-sm" 
                           placeholder="Buscar por nombre, email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" 
                           name="fecha_inicio" 
                           class="form-control form-control-sm"
                           value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" 
                           name="fecha_fin" 
                           class="form-control form-control-sm"
                           value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de respuestas -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre Completo</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Ubicación</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($answers as $answer)
                        <tr>
                            <td>{{ $loop->iteration + ($answers->currentPage() - 1) * $answers->perPage() }}</td>
                            <td>
                                <strong>{{ $answer->nombre }} {{ $answer->apellido }}</strong>
                                @if($answer->user)
                                    <br><small class="text-muted">Usuario: {{ $answer->user->name }}</small>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $answer->tipo_documento }}</small><br>
                                {{ $answer->numero_documento }}
                            </td>
                            <td>
                                <a href="mailto:{{ $answer->email }}" class="text-primary">
                                    {{ $answer->email }}
                                </a>
                            </td>
                            <td>
                                <small>{{ $answer->ciudad }}, {{ $answer->departamento }}</small>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">
                                    {{ $answer->created_at->format('d/m/Y') }}
                                </span><br>
                                <small>{{ $answer->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('answers.show', $answer->id) }}" 
                                       class="btn btn-primary" 
                                       title="Ver respuestas">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="confirmDelete({{ $answer->id }})"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                    <h5>No hay respuestas registradas</h5>
                                    <p>No se han encontrado respuestas con los filtros aplicados.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            @if($answers->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando {{ $answers->firstItem() }} - {{ $answers->lastItem() }} de {{ $answers->total() }}
                </div>
                {{ $answers->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Exportar -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar Respuestas</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            {{-- <div class="modal-body">
                <form action="{{ route('answers.export') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Formato:</label>
                        <select name="format" class="form-control">
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Rango de fechas:</label>
                        <div class="row">
                            <div class="col">
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col">
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Exportar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para eliminar -->
<script>
function confirmDelete(id) {
    if (confirm('¿Está seguro de eliminar esta respuesta?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/answers/${id}`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection