<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.ico')}}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('modernize/css/styles.css')}}" />
    <title>Cepre UNH</title>
</head>

<body>
<!-- Preloader -->
<div class="preloader">
    <img src="{{asset('modernize/images/logos/favicon-unh.png')}}" alt="loader" class="lds-ripple img-fluid" />
</div>
<div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
    <div class="position-relative z-index-5">
        <div class="row">
        <div class="col-xl-7 col-xxl-8">
            <a href="#" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                <img src="{{asset('assets/images/logos/CepreUNH.webp')}}" width="180" class="img-fluid" alt="CepreUNH" />
            </a>
            <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
            <img src="{{asset('assets/images/login-security.svg')}}" alt="" class="img-fluid" width="500">
            </div>
        </div>
        <div class="col-xl-5 col-xxl-4">
            {{ $slot }}
            
        </div>
        </div>
    </div>
    </div>
</div>
<div class="dark-transparent sidebartoggler"></div>
<!-- Import Js Files -->

<script src="{{asset('modernize/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('modernize/js/app.min.js')}}"></script>
<script src="{{asset('modernize/js/app.init.js')}}"></script>
<script src="{{asset('modernize/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('modernize/libs/simplebar/dist/simplebar.min.js')}}"></script>

<script src="{{asset('modernize/js/sidebarmenu.js')}}"></script>
<script src="{{asset('modernize/js/theme.js')}}"></script>

</body>

</html>