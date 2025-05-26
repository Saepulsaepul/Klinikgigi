<div class="container-fluid py-4">
    <!-- Header Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Dashboard Dokter Gigi</h2>
                <div class="btn-group">
                    <button class="btn btn-light" disabled>
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white text-sm mb-0">Janji Hari Ini</h6>
                            <h3 class="mb-0">{{ $stats['today_appointments'] }}</h3>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-7"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white text-sm mb-0">Total Pasien</h6>
                            <h3 class="mb-0">{{ $stats['total_patients'] }}</h3>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-7"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white text-sm mb-0">Perawatan Tertunda</h6>
                            <h3 class="mb-0">{{ $stats['pending_treatments'] }}</h3>
                        </div>
                        <i class="bi bi-clipboard-pulse fs-1 opacity-7"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Jadwal Hari Ini</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Pasien</th>
                                    <th>Perawatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->jam)->format('H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-primary text-white">
                                                    {{ substr($appointment->patient->nama, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $appointment->patient->nama }}</h6>
                                                <small class="text-muted">{{ $appointment->patient->no_hp }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $appointment->pemeriksaan->rencana_perawatan ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status == 'selesai' ? 'success' : 'warning' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button wire:click="showAppointmentDetails({{ $appointment->id }})" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if($appointment->status != 'selesai')
                                        <button wire:click="completeAppointment({{ $appointment->id }})" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pasien -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($patients as $patient)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-primary text-white">
                                        {{ substr($patient->nama, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $patient->nama }}</h6>
                                    <small class="text-muted">{{ $patient->no_hp }}</small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Janji -->
    <div class="modal fade" wire:ignore.self id="appointmentModal" tabindex="-1"
         aria-hidden="true" wire:model="showAppointmentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Janji Temu</h5>
                    <button type="button" class="btn-close" wire:click="$set('showAppointmentModal', false)"></button>
                </div>
                <div class="modal-body">
                    @if($appointmentDetails)
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Pasien</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Nama:</span>
                                    <strong>{{ $appointmentDetails->patient->nama }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>No. HP:</span>
                                    <strong>{{ $appointmentDetails->patient->no_hp }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Umur:</span>
                                    <strong>{{ \Carbon\Carbon::parse($appointmentDetails->patient->tanggal_lahir)->age }} tahun</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Detail Perawatan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Jenis:</span>
                                    <strong>{{ $appointmentDetails->pemeriksaan->tindakan ?? '-' }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Waktu:</span>
                                    <strong>{{ \Carbon\Carbon::parse($appointmentDetails->jam)->format('H:i') }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Biaya:</span>
                                    <strong>@currency(0)</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 mt-3">
                            <h6>Catatan</h6>
                            <div class="card card-body bg-light">
                                {{ $appointmentDetails->pemeriksaan->catatan ?? 'Tidak ada catatan' }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            wire:click="$set('showAppointmentModal', false)">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Style -->
    <style>
        .card:hover {
            transform: scale(1.01);
            transition: transform 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f0f0f0;
        }
    </style>

    <!-- Script untuk modal -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('showAppointmentModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                modal.show();
            });

            Livewire.on('notify', (data) => {
                alert(data.message);
            });
        });
    </script>
</div>
