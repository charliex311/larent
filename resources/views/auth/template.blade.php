<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link 
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('/public/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/assets/css/theme.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('/public/assets/css/user.css') }}" rel="stylesheet" id="user-style-default">
    @livewireStyles
</head>

<body>
    {{ $slot }}
    <script src="{{ asset('/public/vendors/jquery/jquery.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/popper/popper.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/bootstrap/bootstrap.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/anchorjs/anchor.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/is/is.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/fontawesome/all.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/vendors/lodash/lodash.min.js') }}" data-navigate-once></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('/public/vendors/list.js/list.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('/public/assets/js/theme.js') }}" data-navigate-once></script>

    <script src="{{ asset('public/toastr/toastr.min.js') }}" data-navigate-once></script>
    <script data-navigate-track>
        $(document).ready(function() {
            window.addEventListener('successRedirect', function(event) {
                const redirectingDiv = document.getElementById('redirecting');
                redirectingDiv.innerText = event.detail.message;
                redirectingDiv.classList.add('alert', 'alert-success', 'text-capitalize');
            });
            window.addEventListener('warningBack', function(event) {
                const redirectingDiv = document.getElementById('redirecting');
                redirectingDiv.innerText = event.detail.message;
                redirectingDiv.classList.add('alert', 'alert-danger', 'text-capitalize');
            });
        });
    </script>
    @livewireScripts
</body>

</html>