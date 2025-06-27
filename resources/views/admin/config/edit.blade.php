@extends('layouts.admin')

@section('title', 'Editar usuario')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-header-title">Editar usuario</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-soft">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Panel administrador</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar usuario</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <a href="{{ route('home') }}" class="btn btn-soft-secondary">
                <i class="bi-arrow-left me-1"></i> Cancelar
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
                <div class="avatar avatar-xxl mb-3">
                    <img id="profileImage" src="{{ asset('image/'.Auth::user()->image) ?? asset(Auth::user()->image) }}" 
                         alt="profile" class="rounded-circle">
                </div>
                <div class="d-flex justify-content-center">
                    <input type="file" id="profile_image" name="profile_image" class="d-none" />
                    <button type="button" class="btn btn-success" id="changeImageButton">
                        <i class="bi-camera-fill me-1"></i> Cambiar imagen
                    </button>
                </div>
                <div class="mt-3">
                    <h4>{{ $user->name }} {{ $user->surname }}</h4>
                    <p class="text-muted">{{ $user->cedula }}</p>
                 
                       Nivel <p class="text-muted">{{$referidos->depth }}</p> 
                
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Edit Form -->
        <div class="card card-borderless shadow-sm">
            <div class="card-header bg-soft-primary">
                <h5 class="card-header-title">Información del usuario</h5>
            </div>
            <div class="card-body">
                @include('alert.message')
                
                {!! Form::model($user, ['route' => ['configs.update', $user], 'method' => 'PUT']) !!}
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Nombre</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Apellido</label>
                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                               name="surname" value="{{ old('surname', $user->surname) }}" required autocomplete="surname" autofocus>
                        @error('surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Correo electrónico</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <a href="{{ route('password.change') }}" class="btn btn-warning">
                            <i class="bi-shield-lock me-1"></i> Cambiar contraseña
                        </a>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi-save me-1"></i> Actualizar
                    </button>
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Cambiar imagen de perfil
    $('#changeImageButton').click(function() {
        $('#profile_image').click();
    });

    $('#profile_image').change(function() {
        var formData = new FormData();
        formData.append('profile_image', $('#profile_image')[0].files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route('update_profile_image') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#profileImage').attr('src', response.image_url);
                    
                    // Mostrar notificación Falcon style
                    showFalconToast('success', '¡Éxito!', 'Imagen de perfil actualizada correctamente');
                } else {
                    showFalconToast('error', 'Error', 'No se pudo actualizar la imagen');
                }
            },
            error: function() {
                showFalconToast('error', 'Error', 'Ocurrió un error al procesar la solicitud');
            }
        });
    });

    // Función para mostrar notificaciones estilo Falcon
    function showFalconToast(type, title, message) {
        const toastContainer = document.createElement('div');
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '5';
        
        const toastEl = document.createElement('div');
        toastEl.className = `toast show bg-${type} text-white`;
        toastEl.role = 'alert';
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        toastEl.innerHTML = `
            <div class="toast-header bg-${type} text-white">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${message}</div>
        `;
        
        toastContainer.appendChild(toastEl);
        document.body.appendChild(toastContainer);
        
        // Eliminar el toast después de 5 segundos
        setTimeout(() => {
            toastContainer.remove();
        }, 5000);
    }
});
</script>
@endsection