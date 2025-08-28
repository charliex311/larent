<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title></title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/public/assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/public/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/public/assets/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/public/assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('/public/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('/public/assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="turbolinks-visit-control" content="reload">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('/public/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet" data-navigate-once>
    <link href="{{ asset('/public/assets/css/theme.css') }}" rel="stylesheet" id="style-default" data-navigate-once>
    <link href="{{ asset('/public/assets/css/user.css') }}" rel="stylesheet" id="user-style-default" data-navigate-once>
</head>

<main class="main" id="top">
    <div class="container" data-layout="container">
        <div class="row flex-center min-vh-100 py-6 text-center">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
                
                <div class="card">
                    <div class="card-header bg-light">
                        <a class="d-flex flex-center mb-4" href="{{ route('dashboard') }}" >
                            <span class="fw-bolder fs-5 text-uppercase">{{ companyname() }}</span>
                        </a>
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <div class="fw-black lh-1 text-300 fs-error">403</div>
                        <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">You are Unauthorized !</p>
                        <hr />
                        <p>Please Contact to the Author Or you can <a href="{{route('admin-logout')}}"><b>Logout</b></a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('/public/vendors/popper/popper.min.js') }}"></script>
<script src="{{ asset('/public/vendors/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/vendors/anchorjs/anchor.min.js') }}"></script>
<script src="{{ asset('/public/vendors/is/is.min.js') }}"></script>
<script src="{{ asset('/public/vendors/fontawesome/all.min.js') }}"></script>
<script src="{{ asset('/public/vendors/lodash/lodash.min.js') }}"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="{{ asset('/public/vendors/list.js/list.min.js') }}"></script>
<script src="{{ asset('/public/assets/js/theme.js') }}"></script>

</body>

</html>