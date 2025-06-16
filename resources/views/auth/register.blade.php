@extends('layouts.login')

@section('content')
<div class="container-fluid register-container">
    <div class="row min-vh-100 flex-center g-0">
        <!-- Columna izquierda con imagen decorativa -->
        <div class="col-lg-6 d-none d-lg-block register-bg">
            <div class="register-overlay"></div>
            <div class="register-hero-text">
                <h2>Únete a <span>RedCívica</span></h2>
                <p class="mt-3">Forma parte de nuestra comunidad y participa en la construcción colectiva</p>
            </div>
        </div>

        <!-- Columna derecha con el formulario -->
        <div class="col-lg-6 col-12 d-flex align-items-center">
            <div class="card register-card">
                <div class="card-body p-5">
                    <!-- Logo y título -->
                    <div class="text-center mb-5">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <div class="d-flex align-items-center justify-content-center">
                                <h1 class="logo-text"><span>Red</span>Cívica</h1>
                            </div>
                        </a>
                        <h4 class="mt-3">Crear una cuenta</h4>
                        <p class="text-muted">Completa tus datos para registrarte</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="register-form">
                        @csrf

                        <!-- Campo Nombre -->
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Nombre') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="Ej: María">
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>


                        <!-- Campo Apellido -->
                        <div class="mb-4">
                            <label for="surname" class="form-label">{{ __('Apellido') }}</label>
                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" 
                                   name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus
                                   placeholder="Ej: González">
                            @error('surname')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Campo Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="tu@email.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Campo Cédula -->
                        <div class="mb-4">
                            <label for="cedula" class="form-label">{{ __('Cédula') }}</label>
                            <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" 
                                   name="cedula" value="{{ old('cedula') }}" required autocomplete="cedula"
                                   placeholder="Ej: 1234567890"
                                   pattern="[0-9]{10}" title="Ingresa una cédula de 10 dígitos">
                            <small class="text-muted">Ingresa tu número de cédula (10 dígitos)</small>
                            @error('cedula')
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
                                       name="password" required autocomplete="new-password"
                                       placeholder="••••••••">
                                <button type="button" class="password-toggle" aria-label="Mostrar contraseña">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted password-strength-text">Seguridad de la contraseña</small>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                            <div class="password-input-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="••••••••">
                                <button type="button" class="password-toggle" aria-label="Mostrar contraseña">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botón de registro -->
                        <button type="submit" class="btn btn-primary w-100 mb-3 register-btn">
                            {{ __('Registrarse') }}
                        </button>

                        <!-- Enlace a login -->
                        <div class="text-center mt-4">
                            <p class="text-muted">¿Ya tienes una cuenta? 
                                <a href="{{ route('login') }}" class="text-login">{{ __('Iniciar sesión') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales - consistentes con login */
    .register-container {
        background-color: #f8f9fa;
    }
    
    /* Panel izquierdo con imagen */
    .register-bg {
        background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .register-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(211, 82, 82, 0.8);
    }
    
    .register-hero-text {
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
    
    .register-hero-text h2 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .register-hero-text span {
        color: #FFD700;
    }
    
    /* Tarjeta de registro */
    .register-card {
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
    
    /* Indicador de fortaleza de contraseña */
    .password-strength .progress-bar {
        transition: width 0.3s;
    }
    
    .password-strength-text {
        display: block;
    }
    
    /* Botones */
    .register-btn {
        background-color: #D25252;
        border: none;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .register-btn:hover {
        background-color: #B33A3A;
        transform: translateY(-2px);
    }
    
    /* Enlaces */
    .text-login {
        color: #D25252;
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .register-bg {
            display: none;
        }
        
        .register-card {
            box-shadow: none;
            border-radius: 0;
        }
    }
</style>

<script>
    // Toggle para mostrar/ocultar contraseña
    document.querySelectorAll('.password-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Validación de fortaleza de contraseña
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.querySelector('.password-strength .progress-bar');
        const strengthText = document.querySelector('.password-strength-text');
        
        // Calcular fortaleza
        let strength = 0;
        if (password.length > 0) strength += 20;
        if (password.length >= 8) strength += 30;
        if (/[A-Z]/.test(password)) strength += 15;
        if (/[0-9]/.test(password)) strength += 15;
        if (/[^A-Za-z0-9]/.test(password)) strength += 20;
        
        // Actualizar barra y texto
        strengthBar.style.width = strength + '%';
        
        if (strength < 40) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Débil';
        } else if (strength < 70) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Moderada';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Fuerte';
        }
    });

    // Validación de cédula (solo números, máximo 10 dígitos)
    document.getElementById('cedula').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
</script>
@endsection