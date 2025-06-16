@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row flex-center min-vh-100 py-6">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('image/' . $referido->campaña->image) }}" alt="Logo" width="150">
                        </a>
                        <h4 class="mt-3">{{$referido->campaña->name}}</h4>
                        <p class="text-700">Invitado por: {{ $referidor->name }} {{ $referidor->surname }}</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Campos ocultos para tracking -->
                        <input type="hidden" name="parent_id" value="{{ $referidor->id }}">
                        <input type="hidden" name="fuente" value="{{ $fuente }}">
                        <input type="hidden" name="medio" value="{{ $medio }}">

                        <div class="mb-3">
                            <label class="form-label" for="name">Nombres</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" 
                                   name="name" value="{{ old('name') }}" required autocomplete="given-name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="surname">Apellidos</label>
                            <input class="form-control @error('surname') is-invalid @enderror" id="surname" type="text" 
                                   name="surname" value="{{ old('surname') }}" required autocomplete="family-name">
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="cedula">Cédula</label>
                                <input class="form-control @error('cedula') is-invalid @enderror" id="cedula" type="text" 
                                       name="cedula" value="{{ old('cedula') }}" required 
                                       pattern="[0-9]{6,10}" title="Ingresa un número de cédula válido (6-10 dígitos)">
                                @error('cedula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input class="form-control @error('telefono') is-invalid @enderror" id="telefono" type="tel" 
                                       name="telefono" value="{{ old('telefono') }}" 
                                       pattern="[0-9]{10,15}" title="Ingresa un número de teléfono válido">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Correo Electrónico</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input class="form-control @error('direccion') is-invalid @enderror" id="direccion" type="text" 
                                   name="direccion" value="{{ old('direccion') }}">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="barrio">Barrio</label>
                                <input class="form-control @error('barrio') is-invalid @enderror" id="barrio" type="text" 
                                       name="barrio" value="{{ old('barrio') }}">
                                @error('barrio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="ciudad">Ciudad</label>
                                <input class="form-control @error('ciudad') is-invalid @enderror" id="ciudad" type="text" 
                                       name="ciudad" value="{{ old('ciudad') }}">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="mesa">Mesa de Votación</label>
                            <input class="form-control @error('mesa') is-invalid @enderror" id="mesa" type="text" 
                                   name="mesa" value="{{ old('mesa') }}" placeholder="Ej: A12, B05">
                            @error('mesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">términos y condiciones</a>
                            </label>
                            @error('terms')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit">
                                <i class="fas fa-user-plus me-2"></i> Registrarme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Términos y Condiciones -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- @include('partials.terms-and-conditions') --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .password-field {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .form-label {
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        
        // Validación de cédula (solo números)
        document.getElementById('cedula').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Validación de teléfono (solo números)
        document.getElementById('telefono').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection