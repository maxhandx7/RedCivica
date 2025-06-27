    @extends('layouts.admin')
@section('title', 'Información del Usuario')
@section('styles')
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="page-header mt-5">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Detalles del Usuario</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-soft">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Panel Principal</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                    <i class="bi-pencil-fill me-1"></i> Editar
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card card-borderless shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="avatar avatar-xl mb-3">
                            <img src="{{asset('image/' . $business->logo)}}" alt="Foto de perfil" class="profile-avatar rounded-circle">
                        </div>
                        <h3 class="mb-1">{{ $user->name }} {{ $user->surname }}</h3>
                        <p class="text-muted mb-2">
                            {{ $user->cedula ? 'CC: ' . $user->cedula : 'Cédula no registrada' }}
                        </p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-{{ $user->estado()['estado'] ? 'success' : 'danger' }}">
                                {{ $user->estado()['text'] }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around text-center mb-4">
                        <div>
                            <h6 class="p-0 m-0">{{ $user->children->count() ?? 0 }}</h6>
                            <small class="text-muted">Reclutados</small>
                        </div>
                        <div>
                            <h6 class="p-0 m-0">{{ $user->created_at->diffForHumans() }}</h6>
                            <small class="text-muted">Registrado</small>
                        </div>
                        <div>
                            <h6 class="p-0 m-0">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Nunca' }}
                            </h6>
                            <small class="text-muted">Último acceso</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Profile Card -->

      
        </div>

        <div class="col-lg-8">
            <!-- Tab Navigation -->
            <div class="card card-borderless shadow-sm mb-4">
                <div class="card-header bg-primary">
                    <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                                <i class="bi-info-circle me-1"></i> Información
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="recruiter-tab" data-bs-toggle="tab" data-bs-target="#recruiter" type="button" role="tab" aria-controls="recruiter" aria-selected="false">
                                <i class="bi-arrow-down-circle me-1"></i> Reclutado por
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="recruits-tab" data-bs-toggle="tab" data-bs-target="#recruits" type="button" role="tab" aria-controls="recruits" aria-selected="false">
                                <i class="bi-arrow-up-circle me-1"></i> Reclutados ({{ $user->children->count() ?? 0 }})
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- Información Tab -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <h5 class="mb-4">Detalles del Usuario</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de Registro</label>
                                        <p class="form-control-static">{{ $user->created_at->translatedFormat('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Último Acceso</label>
                                        <p class="form-control-static">
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->translatedFormat('d/m/Y H:i') }}
                                                <small class="text-muted">({{ $user->last_login_ip }})</small>
                                            @else
                                                Nunca ha accedido
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Campaña/Origen</label>
                                        <p class="form-control-static">
                                            {{ $user->referencia->campaña->name ?? 'No registrado' }}
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <p class="form-control-static">
                                            <span class="badge bg-{{ $user->estado()['estado'] ? 'success' : 'danger' }}">
                                                {{ $user->estado()['text'] }}
                                            </span>
                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reclutado por Tab -->
                        <div class="tab-pane fade" id="recruiter" role="tabpanel" aria-labelledby="recruiter-tab">
                            @if($user->parent)
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('image/' . $business->logo)}}" alt="Reclutador" class="rounded-circle" width="60">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1">
                                            <a href="{{ route('users.show', $user->parent) }}" class="text-dark">
                                                {{ $user->parent->name }} {{ $user->parent->surname }}
                                            </a>
                                        </h5>
                                        <p class="text-muted mb-1">CC: {{ $user->parent->cedula }}</p>
                                        <p class="text-muted mb-0">{{ $user->parent->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card stat-card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-primary rounded p-3 me-3">
                                                        <i class="bi-people fs-2 text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">{{ $user->parent->children->count() ?? 0 }}</h5>
                                                        <small class="text-muted">Personas reclutadas</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card stat-card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-success rounded p-3 me-3">
                                                        <i class="bi-calendar-check fs-2 text-success"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">{{ $user->parent->created_at->translatedFormat('d/m/Y') }}</h5>
                                                        <small class="text-muted">Fecha de registro</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <img src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}" alt="No data" class="img-fluid mb-3" style="max-width: 200px;">
                                    <h5>No hay información de reclutador</h5>
                                    <p class="text-muted">Este usuario no fue reclutado por otro miembro</p>
                                </div>
                            @endif
                        </div>

                        <!-- Reclutados Tab -->
                        <div class="tab-pane fade" id="recruits" role="tabpanel" aria-labelledby="recruits-tab">
                            @if($user->children && $user->children->count() > 0)
                                <div class="table table-responsive">
                                    <table id="order-listing" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cédula</th>
                                                <th>Contacto</th>
                                                <th>Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->children as $child)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('image/' . $business->logo)}}" alt="{{ $child->name }}" class="rounded-circle me-2" width="30">
                                                            {{ $child->name }} {{ $child->surname }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $child->cedula }}</td>
                                                    <td>
                                                        <div>{{ $child->email }}</div>
                                                        <small class="text-muted">{{ $child->telefono }}</small>
                                                    </td>
                                                    <td>{{ $child->created_at->translatedFormat('d/m/Y') }}</td>
                                                   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <img src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}" alt="No data" class="img-fluid mb-3" style="max-width: 200px;">
                                    <h5>No hay reclutados registrados</h5>
                                    <p class="text-muted">Este usuario no ha reclutado a otros miembros aún</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tab Navigation -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
                  <!-- Quick Stats -->
            <div class="card card-borderless shadow-sm mb-4">
                <div class="card-header bg-primary">
                    <h5 class="card-header-title">Datos de Contacto</h5>
                </div>
                <div class="card-body text-center">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                                <i class="bi-telephone-fill text-primary me-2"></i>
                                <span>{{ $user->telefono ?: 'No registrado' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                                <i class="bi-envelope-fill text-primary me-2"></i>
                                <span>{{ $user->email }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                                <i class="bi-geo-alt-fill text-primary me-2"></i>
                                <span>{{ $user->direccion ?: 'No registrada' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                                <i class="bi-pin-map-fill text-primary me-2"></i>
                                <span>{{ $user->barrio ?: 'No registrado' }}, {{ $user->ciudad ?: '' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                                <i class="bi-check2-square text-primary me-2"></i>
                                <span>{{ $user->mesa ? 'Mesa: ' . $user->mesa : 'Mesa no registrada' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Quick Stats -->
    </div>
</div>
@endsection

@section('scripts')
{!! Html::script('melody/js/data-table.js') !!}
<script>
    // Activar los tabs de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEls.forEach(function(tabEl) {
            tabEl.addEventListener('click', function (event) {
                event.preventDefault();
                var tab = new bootstrap.Tab(tabEl);
                tab.show();
            });
        });
    });
</script>
@endsection