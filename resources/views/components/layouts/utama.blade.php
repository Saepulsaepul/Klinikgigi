<!DOCTYPE html>
<html lang="id">
<head>
    <title>Klinik Fendi Dental - Perawatan Gigi Profesional</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Klinik Gigi Fendi Dental menyediakan layanan perawatan gigi berkualitas dengan teknologi modern dan dokter berpengalaman">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        .ftco-navbar-light .navbar-brand span {
            color: #2f89fc;
        }
        .bg-primary {
            background-color: #2f89fc !important;
        }
        .btn-primary {
            background-color: #2f89fc;
            border-color: #2f89fc;
        }
        .slider-item .overlay {
            background-color: rgba(0, 0, 0, 0.3);
        }
        .color-1 {
            background-color: #2f89fc;
            color: white;
        }
        .color-2 {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Fendi<span>Dental</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="#layanan" class="nav-link">Layanan</a></li>
                    <li class="nav-item"><a href="#tentang" class="nav-link">Tentang Kami</a></li>
                    <li class="nav-item"><a href="#dokter" class="nav-link">Dokter</a></li>
                    <li class="nav-item"><a href="#testimoni" class="nav-link">Testimoni</a></li>
                    <li class="nav-item"><a href="#kontak" class="nav-link">Kontak</a></li>
                    <li class="nav-item cta"><a href="#" class="nav-link" data-toggle="modal" data-target="#modalRequest"><span>Buat Janji Temu</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
        {{ $slot }}
    
  

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&sensor=false"></script>
    <script src="{{ asset('js/google-map.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
      
</body>
</html>