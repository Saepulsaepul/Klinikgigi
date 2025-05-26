<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? 'Mydenti'}}</title>
    
<link rel="icon" type="image/png" href="{{ asset('assets/compiled/jpg/GIGI.jpg') }}">

    <!-- Load CSS -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script>
        function toggleDropdown(event, dropdownId) {
            event.preventDefault();
            let dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }
    
        function closeDropdowns() {
            document.querySelectorAll('.dropdown-menu').forEach(el => {
                el.classList.remove('show');
            });
        }
    
        function initDropdowns() {
            document.querySelectorAll('.dropdown-menu').forEach(el => {
                el.classList.remove('show');
            });
    
            document.addEventListener("click", function (event) {
                if (!event.target.closest('.dropdown')) {
                    closeDropdowns();
                }
            });
        }
    
        // Panggil saat halaman pertama kali dimuat
        document.addEventListener("DOMContentLoaded", initDropdowns);
        // Panggil ulang saat Livewire memperbarui DOM
        document.addEventListener("livewire:load", initDropdowns);
        document.addEventListener("livewire:updated", initDropdowns);
    </script>
    
    @livewireStyles
   
</head>
<body>
 
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a wire:navigate href="/dashboard" class="d-none d-lg-block">Mydenti</a>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/dashboard" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/cabangs" class="sidebar-link">
                                <i class="bi bi-house-add"></i>
                                <span>Klinik</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/users" class="sidebar-link">
                                <i class="bi bi-person-add"></i>
                                <span>Data User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            {{-- <a wire:navigate href="/dokter/create" class="sidebar-link">
                                <i class="bi bi-person-fill"></i>
                                <span>Dokter</span>
                            </a> --}}
                        <li class="sidebar-title">Akun</li>
                        <li class="sidebar-item dropdown" wire:ignore>
                            <a href="#" class="sidebar-link" onclick="toggleDropdown(event, 'profileDropdown')">
                                <i class="bi bi-person-circle"></i>
                                <span>Profil</span>
                            </a>
                            <ul class="dropdown-menu" id="profileDropdown">
                                <li><a class="dropdown-item" wire:navigate href="/profile">Lihat Profil</a></li>
                                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{$slot}}
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span>2025 © Mydenti | Crafted with ❤️ by <a href="https://github.com/Saepulsaepul">Saepul</a></span>
        </div>
    </footer>

    <!-- Load JavaScript -->
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}" defer></script>

    <!-- jQuery & DataTables -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" defer></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}" defer></script>

    @livewireScripts
</body>
</html>
