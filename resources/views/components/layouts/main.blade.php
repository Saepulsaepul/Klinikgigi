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
                margin-left: 0;
            }
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        /* Style untuk tab di modal profil */
        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            padding: 0.75rem 1.5rem;
        }
        
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            background-color: transparent;
            border-bottom: 3px solid #0d6efd;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            border-bottom: 3px solid #dee2e6;
        }
        
        /* Style untuk form password */
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
    

    @livewireStyles
</head>
<body>
  
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="overlay"></div>

    <!-- Header with Hamburger -->
    <nav class="navbar navbar-light bg-light d-xl-none px-3">
        <button class="btn" id="menuToggle">
            <i class="bi bi-list fs-3"></i>
        </button>
       <div class="logo d-flex align-items-center gap-2 mt-4">
     <img src="{{ asset('assets/compiled/jpg/GIGI.jpg') }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
     <span class="navbar-brand ms-2 fw-bold fa-4x">Fendi Dental</span>
       </div>
    </nav>

    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-xl-block">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative d-flex justify-content-between align-items-center p-3">
                    <div class="logo d-flex align-items-center gap-2 mt-4">
                        <img src="{{ asset('assets/compiled/jpg/GIGI.jpg') }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
                        <a href="/main" class="fw-bold fs-5">Fendi Dental</a>
                    </div>
                    <a href="#" class="d-xl-none" id="sidebarClose">
                        <i class="bi bi-x-lg fs-5"></i>
                    </a>
                </div>

                <div class="sidebar-menu px-3">
                    <ul class="menu list-unstyled">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/main" class="sidebar-link d-flex align-items-center">
                                <i class="bi bi-grid-fill me-2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a wire:navigate href="/buat-jadwal" class="sidebar-link d-flex align-items-center">
                                <i class="fas fa-calendar me-2"></i>
                                <span>Buat Jadwal </span>
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
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); showUserProfile();">Lihat Profil</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
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

    <!-- Modal Profil dengan Tab -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengaturan Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Ubah Password</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabsContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            @livewire('auth.user-profile')
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form id="changePasswordForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('current_password', this)"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('new_password', this)"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                        <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('new_password_confirmation', this)"></i>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
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
            
            // Tutup dropdown saat klik di luar area dropdown
            document.addEventListener('click', function(event) {
                if (!event.target.matches('.sidebar-link')) {
                    const dropdowns = document.getElementsByClassName('dropdown-menu');
                    for (let i = 0; i < dropdowns.length; i++) {
                        const openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            });

            // Handle form ubah password
            document.getElementById('changePasswordForm')?.addEventListener('submit', function(e) {
                e.preventDefault();
                // Tambahkan logika AJAX atau Livewire untuk mengubah password
                alert('Password berhasil diubah!');
                // Reset form
                this.reset();
            });
        }); 
        
        function showUserProfile() {
            const profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
            profileModal.show();
        }
    </script>

    @livewireScripts
</body>
</html>