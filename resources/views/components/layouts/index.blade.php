<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mydenti' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/compiled/jpg/GIGI.jpg') }}">

    <!-- Load CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        #sidebar {
            width: 270px;
            transition: all 0.3s ease;
        }

        #main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        @media (max-width: 1199.98px) {
            #sidebar {
                display: none;
                position: fixed;
                z-index: 1030;
                width: 250px;
                height: 100%;
                background-color: #fff;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            }

            #sidebar.active {
                display: block;
            }

            #overlay {
                display: none;
                position: fixed;
                z-index: 1029;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
            }

            #overlay.active {
                display: block;
            }

            #main-content {
                margin-left: 0px;
            }
        }
    </style>

    @livewireStyles
    @stack('scripts')
</head>
<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="overlay"></div>

    <!-- Header with Hamburger -->
    <nav class="navbar navbar-light bg-light d-xl-none px-3">
        <button class="btn" id="menuToggle">
            <i class="bi bi-list fs-3"></i>
        </button>
        <span class="navbar-brand ms-2">Mydenti</span>
    </nav>

    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-xl-block">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative d-flex justify-content-between align-items-center p-3">
                    <div class="logo d-flex align-items-center gap-2 mt-4">
                        <img src="{{ asset('assets/compiled/jpg/GIGI.jpg') }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
                        <a href="#" class="fw-bold fs-5">Fendi Dental</a>
                    </div>
                    <a href="#" class="d-xl-none" id="sidebarClose">
                        <i class="bi bi-x-lg fs-5"></i>
                    </a>
                </div>

                <div class="sidebar-menu px-3">
                    <ul class="menu list-unstyled">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/receptionist-dashboard" class="sidebar-link d-flex align-items-center">
                                <i class="bi bi-grid-fill me-2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/reseptionist-patients" class="sidebar-link d-flex align-items-center">
                                <i class="fas fa-calendar me-2"></i>
                                <span>Pasien</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Akun</li>
                        <li class="sidebar-item dropdown" wire:ignore>
                            <a href="#" class="sidebar-link d-flex align-items-center" onclick="toggleDropdown(event, 'profileDropdown')">
                                <i class="bi bi-person-circle me-2"></i>
                                <span>Profil</span>
                            </a>
                            <ul class="dropdown-menu" id="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                        Lihat Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1 p-4">
            {{ $slot }}
        </div>
    </div>

    <!-- Modal Profil - Gaya Disamakan -->
    <!-- Modal Profil dengan Tab Profil & Ganti Password -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="profileModalLabel">
                    <i class="bi bi-person-circle me-2"></i>Profil Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab-profile" type="button" role="tab">
                            <i class="bi bi-person-lines-fill me-1"></i> Profil Saya
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#tab-password" type="button" role="tab">
                            <i class="bi bi-key me-1"></i> Ganti Password
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="profileTabContent">
                    <!-- Tab Profil -->
                    <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
                        @livewire('auth.user-profile')
                    </div>

                    <!-- Tab Ganti Password -->
                    <div class="tab-pane fade" id="tab-password" role="tabpanel">
                        {{-- @livewire('auth.reset-password') --}}
                    </div>
                </div>
            </div>

            <div class="modal-footer px-4 py-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>


    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span>2025 © Mydenti | Crafted with ❤️ by <a href="https://github.com/Saepulsaepul">Saepul</a></span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown(event, dropdownId) {
            event.preventDefault();
            let dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const toggleBtn = document.getElementById('menuToggle');
            const closeBtn = document.getElementById('sidebarClose');

            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            closeBtn?.addEventListener('click', function () {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            overlay.addEventListener('click', function () {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });
    </script>

    @livewireScripts
</body>
</html>
