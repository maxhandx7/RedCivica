@extends('layouts.login')

@section('content')
    <a href="{{ url('/') }}" class="d-inline-block" id="title-logo">
        <div class="d-flex align-items-center justify-content-center">
            <h1 class="logo-text"><span>Red</span>Cívica</h1>
        </div>
    </a>

    <div class="container">
        <div class="row flex-center min-vh-100 py-6">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4" style="width: auto;">
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">

                            <a href="{{ url('/') }}">
                                <img src="{{ asset('image/' . $referido->campaña->image) }}" alt="Logo" width="200">
                            </a>
                            <h4 class="mt-3">{{ $referido->campaña->name }}</h4>
                            <small class="text-muted">
                                {{ $referido->campaña->description }}
                            </small>
                            <p class="text-700 mt-2">Invitado por: {{ $referidor->name }} {{ $referidor->surname }}</p>
                        </div>
                        @include('alert.message')
                        @if(session('success'))
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-arrow-left"></i> Iniciar sesion
                        </a>
                        @endif
                        @include('admin.form.__form')
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
        #title-logo {
            text-decoration: none;
            color: inherit;
            left: 5% !important;
            top: 10px !important;
            position: absolute;
            z-index: 1000;
        }

        #title-logo h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        #title-logo h1 span {
            color: #D25252;
            /* Cambia el color del texto "Cívica" */
        }

        #top {
            background-image: url('{{ asset('image/' . $referido->campaña->image) }}') !important;
            background-size: cover;

        }

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
