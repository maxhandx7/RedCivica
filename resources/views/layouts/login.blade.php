<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
        <link rel="shortcut icon" type="image/x-icon" href="/image/default.svg">

    <meta name="msapplication-TileImage" content="/image/default.svg">
    <meta name="theme-color" content="#ffffff">

    {!! Html::script('falcon/public/assets/js/config.js') !!}
    {!! Html::script('falcon/public/vendors/simplebar/simplebar.min.js') !!}


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    {!! Html::style('falcon/public/vendors/simplebar/simplebar.min.css') !!}
    {!! Html::style('falcon/public/assets/css/theme-rtl.css', ['id' => 'style-rtl']) !!}
    {!! Html::style('falcon/public/assets/css/theme.css', ['id' => 'style-default']) !!}
    {!! Html::style('falcon/public/assets/css/user-rtl.css', ['id' => 'user-style-rtl']) !!}
    {!! Html::style('falcon/public/assets/css/user.css', ['id' => 'user-style-default']) !!}
    @yield('styles')
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      
        @yield('content')
      
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->





    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    {!! Html::script('falcon/public/vendors/popper/popper.min.js') !!}
    {!! Html::script('falcon/public/vendors/bootstrap/bootstrap.min.js') !!}
    {!! Html::script('falcon/public/vendors/anchorjs/anchor.min.js') !!}
    {!! Html::script('falcon/public/vendors/is/is.min.js') !!}
    {!! Html::script('falcon/public/vendors/fontawesome/all.min.js') !!}
    {!! Html::script('falcon/public/vendors/lodash/lodash.min.js') !!}
    {!! Html::script('falcon/public/vendors/list.js/list.min.js') !!}
    {!! Html::script('falcon/public/assets/js/theme.js') !!}
    @yield('scripts')
  </body>

</html>