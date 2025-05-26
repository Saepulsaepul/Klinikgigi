<div class="container-fluid py-4">
    <div class="row">
        <h2>Form Pemeriksaan</h2>

        <!-- Daftar Jadwal -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Jadwal</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($schedules as $schedule)
                            <button wire:click="selectSchedule({{ $schedule->id }})" 
                                class="list-group-item list-group-item-action {{ $selectedScheduleId == $schedule->id ? 'active' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-{{ $selectedScheduleId == $schedule->id ? 'white text-primary' : 'primary text-white' }}">
                                            {{ substr($schedule->patient->nama, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $schedule->patient->nama }}</h6>
                                        <small class="{{ $selectedScheduleId == $schedule->id ? 'text-white' : 'text-muted' }}">
                                            {{ $schedule->tanggal->format('d/m/Y') }} • {{ $schedule->jam }}
                                        </small>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="list-group-item text-center py-3 text-muted">
                                Tidak ada jadwal terkonfirmasi
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="col-md-8">
            @if(!$selectedPatient)
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5>Silakan pilih jadwal pasien</h5>
                        <p class="text-muted">Pilih dari daftar jadwal di sebelah kiri untuk memulai pemeriksaan</p>
                    </div>
                </div>
            @else
                <!-- Form Pemeriksaan -->
                @if(!$showOdontogram)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Form Pemeriksaan</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveExamination">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6>Informasi Pasien</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Nama:</span>
                                                <strong>{{ $selectedPatient->nama }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Umur:</span>
                                                <strong>{{ \Carbon\Carbon::parse($selectedPatient->tanggal_lahir)->age }} tahun</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>No. HP:</span>
                                                <strong>{{ $selectedPatient->no_hp }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Pemeriksaan</label>
                                            <input type="date" class="form-control" wire:model="examinationData.date">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Pendukung</label>
                                            <input type="file" class="form-control" wire:model="examinationData.images" multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Keluhan Pasien</label>
                                    <textarea class="form-control" rows="3" wire:model="examinationData.complaint" placeholder="Masukkan keluhan pasien..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Diagnosis</label>
                                    <textarea class="form-control" rows="3" wire:model="examinationData.diagnosis" placeholder="Masukkan diagnosis..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Rencana Perawatan</label>
                                    <select class="form-select" wire:model="examinationData.treatment">
                                        <option value="">Pilih Perawatan</option>
                                        @foreach($treatments as $treatment)
                                            <option value="{{ $treatment }}">{{ $treatment }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Catatan Tambahan</label>
                                    <textarea class="form-control" rows="2" wire:model="examinationData.notes" placeholder="Masukkan catatan tambahan..."></textarea>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan & Lanjut ke Odontogram
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Tampilkan Odontogram -->
                    <livewire:dok.odontogram :pemeriksaanId="$lastExaminationId" />
                @endif

                <!-- Riwayat Pemeriksaan -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Riwayat Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keluhan</th>
                                        <th>Diagnosis</th>
                                        <th>Perawatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($examinationHistory as $exam)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($exam['tanggal_pemeriksaan'])->format('d/m/Y') }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($exam['keluhan_pasien'], 30) }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($exam['diagnosis'], 30) }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($exam['rencana_perawatan'], 30) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                Belum ada riwayat pemeriksaan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
