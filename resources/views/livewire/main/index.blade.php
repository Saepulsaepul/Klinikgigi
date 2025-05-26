<div class="container-fluid py-4">
    <div class="row justify-content-center">
        
        <div class="col-lg-10 col-md-11 col-sm-12">
            <h2 class="mb-4 text-center">Dashboard Pasien</h2>

            <!-- Profil Singkat -->
           <div class="card mb-4 shadow-sm rounded">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Selamat datang, {{ $user->name }}!</h5>
            <p class="mb-0 text-muted">{{ $user->email }}</p>
        </div>
        <a href="/buat-jadwal" class="btn btn-outline-primary d-flex align-items-center">
            <i class="fas fa-calendar-plus me-2"></i>
            Booking
        </a>
    </div>
</div>

            <!-- Jadwal Mendatang -->
            <div class="card mb-4 shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal Perawatan Mendatang
                </div>
                <div class="card-body p-0">
                    @if($upcomingAppointments->isEmpty())
                        <div class="p-3 text-center">
                            <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                            <p class="mb-0 text-muted">Belum ada jadwal perawatan.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Dokter</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingAppointments as $appointment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($appointment['tanggal'])->format('d M Y') }}</td>
                                            <td>{{ $appointment['jam'] }}</td>
                                            <td>{{ $appointment['dokter'] }}</td>
                                            <td>{{ $appointment['keterangan'] ?? '-' }}</td>
                                            <td>
                                                @if($appointment['status'] == 'terjadwal')
                                                    <span class="badge bg-warning">menunggu konfirmasi</span>
                                                @elseif($appointment['status'] == 'terkonfirmasi')
                                                    <span class="badge bg-success">Terjadwal</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $appointment['status'] }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Perawatan -->
            <div class="card mb-4 shadow-sm rounded">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-history me-2"></i>Riwayat Perawatan
                </div>
                <div class="card-body p-0">
                    @if($treatmentHistory->isEmpty())
                        <div class="p-3 text-center">
                            <i class="fas fa-file-medical fa-2x text-muted mb-3"></i>
                            <p class="mb-0 text-muted">Belum ada riwayat perawatan.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dokter</th>
                                        <th>Tindakan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($treatmentHistory as $history)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($history['tanggal'])->format('d M Y') }}</td>
                                            <td>{{ $history['dokter'] }}</td>
                                            <td>{{ $history['rencana_perawatan'] ?? '-' }}</td>
                                            <td>{{ $history['keterangan'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Galeri Klinik -->
            <div class="card shadow-sm rounded">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-images me-2"></i>Galeri Klinik
                </div>
                <div class="card-body p-0">
                    <div id="clinicCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/compiled/jpg/klinik.png') }}" class="d-block w-100 rounded" alt="Klinik 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/compiled/jpg/klinik1.png') }}" class="d-block w-100 rounded" alt="Klinik 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/compiled/jpg/klinik2.png') }}" class="d-block w-100 rounded" alt="Klinik 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#clinicCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#clinicCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>