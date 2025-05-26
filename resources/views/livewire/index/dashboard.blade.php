<div class="container-fluid">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Resepsionis
        </h2>
        <div class="badge bg-primary bg-opacity-10 text-primary p-2">
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- Menu Tab -->
    <div wire:ignore.self>
    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab">
                <i class="fas fa-home me-2"></i>Dashboard
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="patient-tab" data-bs-toggle="tab" data-bs-target="#patient-tab-pane" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Data Pasien
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule-tab-pane" type="button" role="tab">
                <i class="fas fa-calendar-plus me-2"></i>Buat Jadwal
            </button>
        </li>
    </ul>
    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent" >
        <!-- Tab Dashboard -->
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <!-- Statistik Cepat -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-start border-primary border-4 shadow-none h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                    <i class="fas fa-user-plus text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Pasien Hari Ini</h6>
                                    <h4 class="mb-0">{{ $pasienHariIni }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-start border-success border-4 shadow-none h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                    <i class="fas fa-calendar-check text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Jadwal Hari Ini</h6>
                                    <h4 class="mb-0">{{ $jadwalHariIni }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-start border-info border-4 shadow-none h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                    <i class="fas fa-clock text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Menunggu Konfirmasi</h6>
                                    <h4 class="mb-0">{{ $menungguKonfirmasi }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Jadwal Pemeriksaan -->
          
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Jadwal Pemeriksaan Hari Ini</h6>
                    <div>
                      <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm">
                       <i class="fas fa-user-plus me-1"></i> Tambah Pasien
                      </a>
                        <button class="btn btn-sm btn-light" wire:click="$refresh" title="Refresh Data" wire:loading.attr="disabled">
                            <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i>
                        </button>
                        <button class="btn btn-sm btn-light ms-2" wire:click="exportJadwal" title="Export Data">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                      @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Pasien</th>
                                    <th>Waktu</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration + ($jadwals->firstItem() - 1) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-primary fs-5"></i>
                                                </div>
                                                <div>
                                                    @if($jadwal->patient)
                                                        <h6 class="mb-0">{{ $jadwal->patient->nama }}</h6>
                                                        <small class="text-muted">{{ $jadwal->patient->no_hp }}</small>
                                                    @else
                                                        <h6 class="mb-0 text-danger">Pasien tidak ditemukan</h6>
                                                        <small class="text-muted">ID: {{ $jadwal->patient_id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') : '-' }}</div>
                                            <div class="text-muted">{{ $jadwal->jam }}</div>
                                        </td>
                                        <td>{{ $jadwal->dokter ?? '-' }}</td>
                                        <td>
                                            @if($jadwal->status == 'terkonfirmasi')
                                                <span class="badge bg-success">Terkonfirmasi</span>
                                            @elseif($jadwal->status == 'terjadwal')
                                                <span class="badge bg-warning text-dark">menunggu konfirmasi</span>
                                            @elseif($jadwal->status == 'selesai')
                                                <span class="badge bg-primary">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $jadwal->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-success" wire:click="confirmJadwal({{ $jadwal->id }})" title="Konfirmasi" wire:loading.attr="disabled">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <a href="{{ route('pasien.edit', $jadwal->patient_id) }}" class="btn btn-outline-primary" title="Edit Pasien">
                                                <i class="fas fa-user-edit"></i>
                                            </a>

                                               <button class="btn btn-outline-danger"
                                                    onclick="if(confirm('Yakin ingin menghapus jadwal ini?')) @this.call('deleteJadwal', {{ $jadwal->id }})"
                                                    title="Hapus" wire:loading.attr="disabled">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="py-3">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <h5>Tidak ada jadwal pemeriksaan hari ini</h5>
                                                <small class="text-muted">Tanggal: {{ now()->format('d M Y') }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $jadwals->count() }} dari {{ $totalJadwal }} jadwal
                    </small>
                    @if(method_exists($jadwals, 'hasPages') && $jadwals->hasPages())
                        {{ $jadwals->links() }}
                    @endif
                </div>
            </div>
        </div>

       <!-- Tab Data Pasien -->
<div class="tab-pane fade" id="patient-tab-pane" role="tabpanel" aria-labelledby="patient-tab" tabindex="0">
    <div class="card shadow">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Data Pasien</h6>
            <div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Cari pasien..." wire:model.debounce.500ms="searchPatient">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama Pasien</th>
                            <th>No. KTP</th>
                            <th>No. HP</th>
                            <th>Jenis Kelamin</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                            <tr wire:key="patient-{{ $patient->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $patient->nama }}</h6>
                                            <small class="text-muted">{{ $patient->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $patient->no_ktp }}</td>
                                <td>{{ $patient->no_hp }}</td>
                                <td>{{ $patient->jenis_kelamin }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                          <a href="{{ route('pasien.edit', $patient->id) }}" class="btn btn-outline-primary" title="Edit Pasien">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                        <button class="btn btn-outline-success" wire:click="createSchedule({{ $patient->id }})" title="Buat Jadwal">
                                            <i class="fas fa-calendar-plus"></i>
                                        </button>
                                        {{-- <button class="btn btn-outline-danger" wire:click="confirmDeletePatient({{ $patient->id }})" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="py-3">
                                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                        <h5>Tidak ada data pasien</h5>
                                        @if($searchPatient)
                                            <p class="text-muted">Tidak ditemukan hasil untuk "{{ $searchPatient }}"</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan {{ $patients->count() }} dari {{ $totalPatients }} pasien</small>
            @if(method_exists($patients, 'hasPages') && $patients->hasPages())
                {{ $patients->links() }}
            @endif
        </div>
    </div>
</div>

<!-- Tab Buat Jadwal -->
<div class="tab-pane fade" id="schedule-tab-pane" role="tabpanel" aria-labelledby="schedule-tab" tabindex="0">
    <div class="card shadow">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Buat Jadwal Pemeriksaan</h6>
            <button class="btn btn-sm btn-light" wire:click="resetScheduleForm" title="Reset Form">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="card-body">
            @if (session()->has('scheduleSuccess'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('scheduleSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($allPatients->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i> Tidak ada pasien yang tersedia. Silakan tambahkan pasien terlebih dahulu.
                </div>
            @endif

            <form wire:submit.prevent="storeSchedule" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pasien <span class="text-danger">*</span></label>
                        <select wire:model.defer="schedule.patient_id" class="form-select @error('schedule.patient_id') is-invalid @enderror" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($allPatients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->nama }} ({{ $patient->no_ktp }})</option>
                            @endforeach
                        </select>
                        @error('schedule.patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                        <input wire:model.defer="schedule.tanggal" type="date" class="form-control @error('schedule.tanggal') is-invalid @enderror" required min="{{ now()->format('Y-m-d') }}">
                        @error('schedule.tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Waktu Pemeriksaan <span class="text-danger">*</span></label>
                        <input wire:model.defer="schedule.jam" type="time" class="form-control @error('schedule.jam') is-invalid @enderror" required>
                        @error('schedule.jam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dokter <span class="text-danger">*</span></label>
                        <select wire:model.defer="schedule.dokter" class="form-select @error('schedule.dokter') is-invalid @enderror" required>
                            <option value="">Pilih Dokter</option>
                            <option value="Drg.Ahmad Efendi.AMK.SPDI"> Drg.Ahmad Efendi.AMK.SPDI </option>
                            {{-- <option value="Dr. Budi">Dr. Budi</option>
                            <option value="Dr. Citra">Dr. Citra</option> --}}
                        </select>
                        @error('schedule.dokter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea wire:model.defer="schedule.keterangan" class="form-control @error('schedule.keterangan') is-invalid @enderror" rows="3" placeholder="Catatan tambahan..." autocomplete="off"></textarea>
                        @error('schedule.keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2" wire:click="resetScheduleForm">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button class="btn btn-warning px-4" type="submit" wire:loading.attr="disabled">
                        <i class="fas fa-save me-2"></i>
                        <span wire:loading.remove>Simpan Jadwal</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script SweetAlert untuk Konfirmasi Hapus -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('confirm-delete', (data) => {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.type,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(data.method, data.id);
                }
            });
        });
    });
     
</script>
