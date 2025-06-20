@extends('layouts.admin')
@section('title', 'Gestión de Campañas')
@section('styles')
<link href="{{ asset('falcon/css/tabler.min.css') }}" rel="stylesheet">
<style>
    .campaign-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    .table-responsive {
        min-height: 300px;
    }
    .search-box {
        max-width: 300px;
    }
</style>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Campañas</h5>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm search-box">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar..." id="search-input">
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('campañas.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus me-1"></i> Agregar
                </a>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        @include('alert.message')
        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped mb-0" id="campaigns-table">
                <thead class="bg-200">
                    <tr>
                        <th class="sort" data-sort="image">Imagen</th>
                        <th class="sort" data-sort="name">Nombre</th>
                        <th class="sort" data-sort="description">Descripción</th>
                        <th class="sort" data-sort="type">Tipo</th>
                        <th class="sort" data-sort="status">Estado</th>
                        <th class="sort" data-sort="dates">Fechas</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($campañas as $campaña)
                    <tr>
                        <td class="image">
                            @if ($campaña->image)
                                <img src="{{ asset('image/'.$campaña->image) }}" width="65px"  class="campaign-image">
                            @else
                                <img src="{{ asset('image/system/default.jpg') }}" width="65px"  class="campaign-image">
                            @endif
                        </td>
                        <td class="name">{{ $campaña->name }}</td>
                        <td class="description">{{ Str::limit($campaña->description, 50) }}</td>
                        <td class="type">
                            <span class="badge bg-{{ $campaña->tipo == 'publica' ? 'success' : 'info' }}">
                                {{ ucfirst($campaña->tipo) }}
                            </span>
                        </td>
                        <td class="status">
                            <span class="badge bg-{{ $campaña->estado == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($campaña->estado) }}
                            </span>
                        </td>
                        <td class="dates">
                            @if($campaña->fecha_inicio && $campaña->fecha_fin)
                                {{ $campaña->fecha_inicio }} al {{ $campaña->fecha_fin }}
                            @else
                                <span class="text-muted">Sin fechas</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('campañas.edit', $campaña) }}" class="btn btn-sm btn-link" data-bs-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['campañas.destroy', $campaña], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                <button type="submit" class="btn btn-sm btn-link text-danger" data-bs-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Estás seguro?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Paginación simple -->
        @if($campañas->hasPages())
        <div class="d-flex justify-content-center mt-3">
            <nav>
                {{ $campañas->links('pagination::bootstrap-4') }}
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
{!! Html::script('/falcon/public/vendors/sortablejs/Sortable.min.js') !!}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar List.js
    var options = {
        valueNames: ['name', 'description', 'type', 'status', 'dates'],
        page: 10,
        pagination: true
    };
    
    var campaignList = new List('campaigns-table', options);
    
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Ordenamiento por columnas
    document.querySelectorAll('.sort').forEach(header => {
        header.addEventListener('click', () => {
            const column = header.getAttribute('data-sort');
            campaignList.sort(column, { order: campaignList.sorting.order === 'asc' ? 'desc' : 'asc' });
        });
    });
});
</script>
@endsection