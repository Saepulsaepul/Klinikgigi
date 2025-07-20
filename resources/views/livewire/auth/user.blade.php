<div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>User Management</h3>
                    <p class="text-subtitle text-muted">Kelola Data Pengguna</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <!-- Staff Table (Dokter and Resepsionis) -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Staff List (Dokter & Resepsionis)</h5>
                    <div>
                        <button wire:click="togglePasien" class="btn btn-outline-primary">
                            {{ $showPasien ? 'Sembunyikan Pasien' : 'Tampilkan Pasien' }}
                        </button>
                        <a wire:navigate href="/users/create" class="btn btn-primary ms-2">Tambah User</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="staffTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Cabang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users->whereIn('role', ['dokter', 'resepsionis']) as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ $user->cabang->nama ?? '-' }}</td>
                                    <td>
                                        <a wire:navigate href="/users/{{$user->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                                        <button 
                                            wire:click="delete({{$user->id}})"
                                            wire:confirm='Apakah anda yakin ingin menghapus data ini?'
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Patients Table - Hanya muncul ketika $showPasien true -->
            @if($showPasien)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Patient List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="patientTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cabang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users->where('role', 'pasien') as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->cabang->nama ?? '-' }}</td>
                                    <td>
                                        <a wire:navigate href="/users/{{$user->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                                        <button 
                                            wire:click="delete({{$user->id}})"
                                            wire:confirm='Apakah anda yakin ingin menghapus data ini?'
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>
</div>