@extends('layouts.form')

@section('content')
    <a href="{{ url('/') }}" class="d-inline-block" id="title-logo">
        <div class="d-flex align-items-center justify-content-center">
            <h1 class="logo-text"><span>Politic</span>Friends</h1>
        </div>
    </a>
    <div class="container-fluid form-container ">
        <div class="row justify-content-center align-items-center min-vh-100 ">
            <div class="col-md-8 col-lg-6 mt-3">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-center py-4 ">
                        <h2 class="text-white">{{ $referido->campaña->name }}</h2>
                        <p class="mb-0">{{ $referido->campaña->description }}</p>
                        <small>Invitado por: {{ $referidor->name }} {{ $referidor->surname }}</small>
                    </div>

                   
                        @include('alert.message')
                        @if (session('success'))
                            <div class="text-center mb-4">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Iniciar sesión
                                </a>
                            </div>
                        @endif
                        @include('admin.form.form_body')
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Términos y Condiciones -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Términos y Condiciones</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.terms-and-conditions')
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
        .form-container {
            background: url('{{ asset('image/' . $referido->campaña->image) }}') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
        }

        .campaign-logo {
            max-height: 80px;
            width: auto;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

       

    

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
            opacity: 0.55;
        }

        #title-logo h1 span {
            color: #D25252;
        }

        .card-header {
            background-image: url('{{ asset('image/' . $referido->campaña->image) }}') !important;
            background-size: cover;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.25);
        }

        .card-header>* {
            position: relative;
        }
    </style>
@endsection
