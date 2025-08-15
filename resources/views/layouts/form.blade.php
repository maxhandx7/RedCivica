<!DOCTYPE html>
<html data-bs-theme="light" lang="es-CO" dir="ltr">

<head>
    <!-- Metadatos básicos -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $referido->campaña->name }}</title>
    <meta name="description" content="{{ $referido->campaña->description }}">

    <!-- Favicon y compatibilidad con plataformas -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/' . $referido->campaña->image) }}">
    <link rel="icon" href="{{ asset('image/' . $referido->campaña->image) }}" sizes="32x32">
    <link rel="icon" href="{{ asset('image/' . $referido->campaña->image) }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('image/' . $referido->campaña->image) }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="application-name" content="{{ $referido->campaña->name }}">
    <meta name="apple-mobile-web-app-title" content="{{ $referido->campaña->name }}">



    <!-- Compatibilidad con Windows -->
    <meta name="msapplication-TileImage" content="{{ asset('image/' . $referido->campaña->image) }}">
    <meta name="theme-color" content="#ffffff">


    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    {!! Html::style('falcon/public/vendors/simplebar/simplebar.min.css') !!}
    {!! Html::style('falcon/public/assets/css/theme.css', ['id' => 'style-default']) !!}
    {!! Html::style('falcon/public/assets/css/user.css', ['id' => 'user-style-default']) !!}

    @yield('styles')
</head>

<body>
    <main class="main" id="top">
        @yield('content')
    </main>

    <!-- JavaScripts -->
    {!! Html::script('melody/vendors/js/vendor.bundle.base.js') !!}
    {!! Html::script('melody/vendors/js/vendor.bundle.addons.js') !!}
    {!! Html::script('/falcon/public/vendors/popper/popper.min.js') !!}
    {!! Html::script('/falcon/public/vendors/bootstrap/bootstrap.min.js') !!}
    {!! Html::script('/falcon/public/vendors/anchorjs/anchor.min.js') !!}
    {!! Html::script('/falcon/public/vendors/is/is.min.js') !!}
    {!! Html::script('/falcon/public/vendors/fontawesome/all.min.js') !!}
    {!! Html::script('/falcon/public/vendors/lodash/lodash.min.js') !!}
    {!! Html::script('/falcon/public/vendors/list.js/list.min.js') !!}
    {!! Html::script('/falcon/public/assets/js/theme.js') !!}
    @yield('scripts')
</body>

</html>
