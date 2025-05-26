<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('assets/compiled/jpg/GIGI.jpg') }}">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ $title ?? "Mydenti" }}</title>

    <!-- Tambahkan Livewire Styles -->
    @livewireStyles
</head>
<body class="d-flex justify-content-center align-items-center vh-100" 
      style="background: url('{{ asset('assets/compiled/jpg/dental.jpg') }}') no-repeat center center/cover;">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>


    {{ $slot }}

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Tambahkan Livewire Scripts -->
    @livewireScripts
</body>
</html>
