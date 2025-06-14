@extends('layouts.login')

@section('content')
<div class="container-fluid login-container">
    <div class="row min-vh-100 flex-center g-0">
        <!-- Columna izquierda con imagen decorativa (solo en pantallas grandes) -->
        <div class="col-lg-6 d-none d-lg-block login-bg">
            <div class="login-overlay"></div>
            <div class="login-hero-text">
                <h2>Bienvenido a <span>RedCívica</span></h2>
                <p class="mt-3">Plataforma de participación ciudadana y gestión comunitaria</p>
            </div>
        </div>

        <!-- Columna derecha con el formulario -->
        <div class="col-lg-6 col-12 d-flex align-items-center">
            <div class="card login-card">
                <div class="card-body p-5">
                    <!-- Logo y título -->
                    <div class="text-center mb-5">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <div class="d-flex align-items-center justify-content-center">
                                <h1 class="logo-text"><span>Red</span>Cívica</h1>
                            </div>
                        </a>
                        <h4 class="mt-3">Iniciar sesión</h4>
                        <p class="text-muted">Ingresa tus credenciales para acceder</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Campo Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Correo electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="tu@email.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <div class="password-input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="••••••••">
                                <button type="button" class="password-toggle" aria-label="Mostrar contraseña">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Recordar sesión y enlaces -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Recordar sesión') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-forgot">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Botón de inicio de sesión -->
                        <button type="submit" class="btn btn-primary w-100 mb-3 login-btn">
                            {{ __('Entrar') }}
                        </button>

                        <!-- Registro y login con Google -->
                        <div class="text-center mt-4">
                            <p class="text-muted mb-3">¿No tienes una cuenta? 
                                <a href="{{ route('register') }}" class="text-register">{{ __('Regístrate') }}</a>
                            </p>
                            
                            <div class="divider my-4">o</div>
                            
                            <a href="#" class="btn btn-outline-google w-100">
                                <img src="/falcon/public/assets/img/gallery/Google__G__logo.svg" alt="Google" class="google-icon">
                                {{ __('Iniciar sesión con Google') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .login-container {
        background-color: #f8f9fa;
    }
    
    /* Panel izquierdo con imagen */
    .login-bg {
        background-image: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .login-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(211, 82, 82, 0.8);
    }
    
    .login-hero-text {
        position: relative;
        z-index: 1;
        color: white;
        padding: 2rem;
        max-width: 80%;
        margin: 0 auto;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .login-hero-text h2 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .login-hero-text span {
        color: #FFD700;
    }
    
    /* Tarjeta de login */
    .login-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }
    
    /* Logo */
    .logo-text {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
    }
    
    .logo-text span {
        color: #D25252;
    }
    
    /* Campos de formulario */
    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    .form-control:focus {
        border-color: #D25252;
        box-shadow: 0 0 0 0.25rem rgba(210, 82, 82, 0.25);
    }
    
    /* Grupo de contraseña */
    .password-input-group {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
    }
    
    /* Botones */
    .login-btn {
        background-color: #D25252;
        border: none;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .login-btn:hover {
        background-color: #B33A3A;
        transform: translateY(-2px);
    }
    
    /* Botón Google */
    .btn-outline-google {
        border: 1px solid #ddd;
        color: #444;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 10px;
        border-radius: 8px;
    }
    
    .btn-outline-google:hover {
        background-color: #f8f9fa;
        border-color: #ccc;
    }
    
    .google-icon {
        width: 18px;
        height: 18px;
    }
    
    /* Divisor */
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #6c757d;
    }
    
    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #dee2e6;
    }
    
    .divider::before {
        margin-right: 1rem;
    }
    
    .divider::after {
        margin-left: 1rem;
    }
    
    /* Enlaces */
    .text-forgot {
        color: #6c757d;
    }
    
    .text-register {
        color: #D25252;
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .login-bg {
            display: none;
        }
        
        .login-card {
            box-shadow: none;
            border-radius: 0;
        }
    }
</style>

<script>
    // Toggle para mostrar/ocultar contraseña
    document.querySelector('.password-toggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
@endsection