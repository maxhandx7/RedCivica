<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $candidato->nombre_completo }} - {{ $candidato->cargo }} por {{ $candidato->circunscripcion }}">
    <title>{{ $candidato->nombre_completo }} - Propuestas para {{ $candidato->circunscripcion }}</title>
    <link rel="icon" href="{{ Storage::url($candidato->imagen ?? 'default-favicon.ico') }}" type="image/x-icon">
    <meta name="author" content="Alan Carabali">
    <meta name="keywords"
        content="Candidato, {{ $candidato->cargo }}, {{ $candidato->circunscripcion }} Propuestas, Campaña, Elecciones, Política">
    <meta name="robots" content="index, follow">


    <!-- Favicon y compatibilidad con plataformas -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($candidato->imagen) }}">
    <link rel="icon" href="{{ Storage::url($candidato->imagen) }}" sizes="32x32">
    <link rel="icon" href="{{ Storage::url($candidato->imagen) }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ Storage::url($candidato->imagen) }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="application-name" content="{{ $candidato->nombre_completo }}">
    <meta name="apple-mobile-web-app-title" content="{{ $candidato->nombre_completo }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $candidato->nombre_completo }}">
    <meta property="og:description"
        content="{{ $candidato->cargo }} por {{ $candidato->circunscripcion }} - Conoce sus propuestas y planes para el futuro.">
    <meta property="og:image" content="{{ Storage::url($candidato->imagen) }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:site_name" content="PoliticFriends">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $candidato->nombre_completo }}">
    <meta name="twitter:description"
        content="{{ $candidato->cargo }} por {{ $candidato->circunscripcion }} - Descubre sus propuestas y visión para el futuro.">
    <meta name="twitter:image" content="{{ Storage::url($candidato->imagen) }}">




    <!-- Compatibilidad con Windows -->
    <meta name="msapplication-TileImage" content="{{ Storage::url($candidato->imagen) }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary-color: {{ $candidato->color_principal }};
            --primary-light: {{ $candidato->color_principal }}20;
            --gradient-primary: linear-gradient(135deg, {{ $candidato->color_principal }} 0%, #{{ substr($candidato->color_principal, 1) }}88 100%);
            --gradient-dark: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .hero-section {
            background: var(--gradient-primary);
            color: white;
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><path fill="white" d="M0,500L500,1000L1000,500L500,0Z"/></svg>') center/cover;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            100% {
                transform: translateY(-1000px) rotate(360deg);
            }
        }

        .candidate-avatar {
            width: 200px;
            height: 200px;
            border: 5px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .candidate-avatar:hover {
            transform: scale(1.05);
        }

        .party-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .section-title {
            position: relative;
            margin-bottom: 3rem;
            text-align: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .proposal-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .proposal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .proposal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .category-badge {
            font-size: 0.75rem;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stats-counter {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .stats-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-light);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 5px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .quote-section {
            background: linear-gradient(rgba(30, 60, 114, 0.9), rgba(30, 60, 114, 0.9)), url('https://images.unsplash.com/photo-1551135049-8a33b2fb2f5f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-attachment: fixed;
            color: white;
            padding: 100px 0;
        }

        .quote-icon {
            font-size: 3rem;
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        .footer {
            background: var(--gradient-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: #1e3c72;
            transform: translateY(-5px);
        }

        .btn-outline-success {
            --bs-btn-color: var(--primary-color) !important;
            --bs-btn-border-color: var(--primary-color) !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--primary-color) !important;
            --bs-btn-hover-border-color var(--primary-color): var(--primary-color) !important;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: var(--primary-color) !important;
            --bs-btn-active-border-color: var(--primary-color) !important;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: var(--primary-color) !important;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: var(--primary-color) !important;
            --bs-gradient: none;
            boder-color: var(--primary-color) !important;
        }

        .btn:hover {
            border-color: var(--primary-color) !important;
        }

        /* Animaciones personalizadas */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0 40px;
                text-align: center;
            }

            .candidate-avatar {
                width: 150px;
                height: 150px;
                margin: 0 auto 20px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .stats-counter {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Botón volver arriba -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center text-lg-start animate-on-scroll">
                    <div class="position-relative">
                        @if ($candidato->imagen)
                            <img src="{{ Storage::url($candidato->imagen) }}" alt="{{ $candidato->nombre_completo }}"
                                class="candidate-avatar rounded-circle">
                        @else
                            <div class="candidate-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mx-lg-0"
                                style="background: white; color: var(--primary-color);">
                                <span class="display-1 fw-bold">{{ $candidato->iniciales }}</span>
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0 bg-white rounded-pill px-3 py-1 shadow-sm">
                            <span class="badge party-badge text-dark">{{ $candidato->partido }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 text-center text-lg-start animate-on-scroll" style="animation-delay: 0.2s">
                    <h6 class="text-uppercase mb-2 opacity-75">Candidato a {{ ucfirst($candidato->cargo) }}</h6>
                    <h1 class="display-4 fw-bold mb-3">{{ $candidato->nombre_completo }}</h1>
                    @if ($candidato->alias)
                        <h3 class="mb-4" style="font-weight: 300;">"{{ $candidato->alias }}"</h3>
                    @endif
                    <h4 class="mb-4">
                        <span class="badge bg-light text-dark px-4 py-2 rounded-pill fs-5">
                            <i class="fas fa-user-tie me-2"></i>
                            {{ ucfirst($candidato->cargo) }} por {{ $candidato->circunscripcion }}
                        </span>
                    </h4>

                    @if ($candidato->lema)
                        <div class="mt-4">
                            <p class="lead mb-0" style="font-style: italic; opacity: 0.9;">
                                <i class="fas fa-quote-left me-2"></i>
                                {{ $candidato->lema }}
                                <i class="fas fa-quote-right ms-2"></i>
                            </p>
                        </div>
                    @endif

                    <div class="mt-4 social-links">
                        <a href="#" class="animate__animated animate__pulse animate__infinite"
                            style="animation-delay: 0.3s"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="animate__animated animate__pulse animate__infinite"
                            style="animation-delay: 0.4s"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="animate__animated animate__pulse animate__infinite"
                            style="animation-delay: 0.5s"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="animate__animated animate__pulse animate__infinite"
                            style="animation-delay: 0.6s"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6 text-center animate-on-scroll">
                    <div class="p-4">
                        <div class="stats-counter">{{ $candidato->propuestas->count() }}</div>
                        <div class="stats-label">Propuestas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center animate-on-scroll" style="animation-delay: 0.1s">
                    <div class="p-4">
                        <div class="stats-counter">{{ count($estadisticas['propuestas_por_categoria']) }}</div>
                        <div class="stats-label">Categorías</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center animate-on-scroll" style="animation-delay: 0.2s">
                    <div class="p-4">
                        <div class="stats-counter">
                            {{ $estadisticas['propuestas_destacadas'] ?? $candidato->propuestas->where('destacada', true)->count() }}
                        </div>
                        <div class="stats-label">Destacadas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center animate-on-scroll" style="animation-delay: 0.3s">
                    <div class="p-4">
                        <div class="stats-counter">{{ $candidato->fecha_eleccion->diffInDays(now()) }}</div>
                        <div class="stats-label">Días Restantes</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Propuestas Destacadas -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Propuestas Destacadas</h2>

            @if ($candidato->propuestas->where('destacada', true)->count() > 0)
                <div class="row g-4">
                    @foreach ($candidato->propuestas->where('destacada', true)->take(3) as $propuesta)
                        <div class="col-lg-4 animate-on-scroll" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="proposal-card">
                                <div class="card-body p-4">
                                    <div class="proposal-icon"
                                        style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                        <i class="{{ $propuesta->icono }}"></i>
                                    </div>
                                    <span class="category-badge mb-3 d-inline-block"
                                        style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                        {{ $propuesta->categoria_formateada }}
                                    </span>
                                    <h5 class="card-title mb-3">{{ $propuesta->titulo }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($propuesta->descripcion, 120) }}</p>
                                    <div class="mt-4">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i> Destacada
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 animate-on-scroll">
                    <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                    <p class="lead text-muted">Próximamente se publicarán las propuestas destacadas</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Todas las Propuestas por Categoría -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Propuestas por Área</h2>

            @if ($candidato->propuestas->count() > 0)
                <!-- Navegación por categorías -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="nav nav-pills justify-content-center" id="categoriesTab" role="tablist">
                            <button class="nav-link active mx-2 mb-2" id="all-tab" data-bs-toggle="pill"
                                data-bs-target="#all" type="button">
                                Todas ({{ $candidato->propuestas->count() }})
                            </button>
                            @foreach ($estadisticas['propuestas_por_categoria'] as $categoria => $total)
                                <button class="nav-link mx-2 mb-2" id="{{ $categoria }}-tab"
                                    data-bs-toggle="pill" data-bs-target="#{{ $categoria }}" type="button">
                                    {{ ucfirst(str_replace('_', ' ', $categoria)) }} ({{ $total }})
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Contenido de las categorías -->
                <div class="tab-content" id="categoriesTabContent">
                    <!-- Todas las propuestas -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        <div class="row g-4">
                            @foreach ($candidato->propuestas as $propuesta)
                                <div class="col-lg-4 col-md-6 animate-on-scroll">
                                    <div class="proposal-card">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="proposal-icon me-3"
                                                    style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                                    <i class="{{ $propuesta->icono }}"></i>
                                                </div>
                                                <div>
                                                    <span class="category-badge d-inline-block mb-2"
                                                        style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                                        {{ $propuesta->categoria_formateada }}
                                                    </span>
                                                    @if ($propuesta->destacada)
                                                        <span class="badge bg-warning text-dark ms-1">Destacada</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-3">{{ $propuesta->titulo }}</h5>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($propuesta->descripcion, 150) }}</p>
                                            @if ($propuesta->metas && count($propuesta->metas) > 0)
                                                <div class="mt-3">
                                                    <small class="text-primary fw-bold">Metas específicas:</small>
                                                    <ul class="list-unstyled mt-2">
                                                        @foreach (array_slice($propuesta->metas, 0, 2) as $meta)
                                                            <li class="mb-1">
                                                                <i class="fas fa-check-circle text-success me-2"
                                                                    style="font-size: 0.8rem;"></i>
                                                                <small>{{ $meta }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Propuestas por categoría -->
                    @foreach ($estadisticas['propuestas_por_categoria'] as $categoria => $total)
                        <div class="tab-pane fade" id="{{ $categoria }}" role="tabpanel">
                            <div class="row g-4">
                                @foreach ($candidato->propuestas->where('categoria', $categoria) as $propuesta)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="proposal-card">
                                            <div class="card-body p-4">
                                                <div class="proposal-icon mb-3"
                                                    style="background-color: {{ $propuesta->color }}20; color: {{ $propuesta->color }};">
                                                    <i class="{{ $propuesta->icono }}"></i>
                                                </div>
                                                <h5 class="card-title mb-3">{{ $propuesta->titulo }}</h5>
                                                <p class="card-text text-muted">{{ $propuesta->descripcion }}</p>
                                                @if ($propuesta->metas && count($propuesta->metas) > 0)
                                                    <div class="mt-4">
                                                        <h6 class="text-primary">Metas:</h6>
                                                        <ul class="list-unstyled">
                                                            @foreach ($propuesta->metas as $meta)
                                                                <li class="mb-2">
                                                                    <i
                                                                        class="fas fa-check-circle text-success me-2"></i>
                                                                    {{ $meta }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                @if ($propuesta->destacada)
                                                    <div class="mt-3">
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-star me-1"></i> Propuesta Prioritaria
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 animate-on-scroll">
                    <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                    <p class="lead text-muted">El candidato está trabajando en sus propuestas</p>
                    <p class="text-muted">Vuelve pronto para conocer sus planes</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Biografía -->
    @if ($candidato->biografia)
        <section class="py-5">
            <div class="container">
                <h2 class="section-title animate-on-scroll">Conoce al Candidato</h2>
                <div class="row align-items-center animate-on-scroll">
                    <div class="col-lg-8">
                        <div class="timeline">
                            @php
                                // Dividir biografía en puntos clave (simulado)
                                $biografia_puntos = preg_split('/\n+/', $candidato->biografia);
                            @endphp

                            @foreach ($biografia_puntos as $index => $punto)
                                @if (trim($punto))
                                    <div class="timeline-item">
                                        <h5 class="mb-2">Experiencia {{ $index + 1 }}</h5>
                                        <p class="text-muted mb-0">{{ trim($punto) }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="p-5">
                            <i class="fas fa-user-tie fa-5x text-primary mb-4"></i>
                            <h4 class="mb-3">{{ $candidato->nombre_completo }}</h4>
                            <p class="text-muted">{{ $candidato->cargo_formateado }}</p>
                            <div class="mt-4">
                                <div class="mb-3">
                                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                                    <span>{{ $candidato->circunscripcion }}</span>
                                </div>
                                <div class="mb-3">
                                    <i class="fas fa-calendar-alt text-info me-2"></i>
                                    <span>Elección: {{ $candidato->fecha_eleccion->translatedFormat('d F Y') }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-flag text-warning me-2"></i>
                                    <span>{{ $candidato->partido }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Cita Inspiradora -->
    <section class="quote-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-on-scroll">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <h3 class="mb-4" style="font-weight: 300; line-height: 1.6;">
                        "Un futuro mejor para {{ $candidato->circunscripcion }} no es solo un sueño,
                        es un compromiso que asumo con responsabilidad y determinación."
                    </h3>
                    <div class="mt-4">
                        <h5 class="mb-0">{{ $candidato->nombre_completo }}</h5>
                        <p class="opacity-75 mb-0">{{ ucfirst($candidato->cargo) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
    <footer class="fixed-bottom ">
        <div class="container text-center py-2">
            <a href="{{ url('/') }}" class="btn btn-outline-success">
                &#8592; Volver Atrás
            </a>
        </div>
    </footer>
    @endauth

    <!-- Pie de página -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="mb-4">{{ $candidato->nombre_completo }}</h4>
                    <p class="opacity-75">
                        {{ ucfirst($candidato->cargo) }} por {{ $candidato->circunscripcion }}<br>
                        Partido: {{ $candidato->partido }}
                    </p>
                    <div class="social-links mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-4">Información de Contacto</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            contacto {{ Str::slug($candidato->nombre_completo) }}.com
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $candidato->circunscripcion }}
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h5 class="mb-4">Próximos Eventos</h5>
                    <div class="opacity-75">
                        <p class="mb-3">
                            <strong>Foro Ciudadano:</strong><br>
                            {{ now()->addDays(7)->translatedFormat('d F Y') }}
                        </p>
                        <p class="mb-3">
                            <strong>Gran Mitin:</strong><br>
                            {{ now()->addDays(14)->translatedFormat('d F Y') }}
                        </p>
                        <p>
                            <strong>Elecciones:</strong><br>
                            {{ $candidato->fecha_eleccion->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <hr class="my-5 opacity-25">

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 opacity-75">
                        &copy; {{ date('Y') }} {{ $candidato->nombre_completo }}. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 opacity-75">
                        Diseñado con <i class="fas fa-heart text-danger"></i> para los amigos de
                        {{ request()->host() }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Animaciones al hacer scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (elementTop < windowHeight - 100) {
                    element.classList.add('animated');
                }
            });
        }

        // Mostrar/ocultar botón volver arriba
        function toggleBackToTop() {
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        }

        // Inicializar gráfico de categorías
        function initChart() {
            const ctx = document.getElementById('categoriasChart');
            if (!ctx) return;

            const categorias = @json(array_keys($estadisticas['propuestas_por_categoria']->toArray()));
            const datos = @json(array_values($estadisticas['propuestas_por_categoria']->toArray()));

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categorias.map(cat => cat.charAt(0).toUpperCase() + cat.slice(1).replace('_', ' ')),
                    datasets: [{
                        data: datos,
                        backgroundColor: [
                            '#007bff', '#28a745', '#ffc107', '#dc3545',
                            '#17a2b8', '#6f42c1', '#e83e8c', '#20c997'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar animaciones
            animateOnScroll();

            // Inicializar gráfico
            initChart();

            // Botón volver arriba
            document.getElementById('backToTop').addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        window.addEventListener('scroll', function() {
            animateOnScroll();
            toggleBackToTop();
        });

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Contador regresivo para las elecciones
        function updateCountdown() {
            const electionDate = new Date('{{ $candidato->fecha_eleccion->format('Y-m-d') }}');
            const now = new Date();
            const diff = electionDate - now;

            if (diff > 0) {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const countdownElement = document.querySelector('.stats-counter:nth-child(4)');
                if (countdownElement) {
                    countdownElement.textContent = days;
                }
            }
        }

        // Actualizar contador cada minuto
        setInterval(updateCountdown, 60000);
        updateCountdown();
    </script>
</body>

</html>
