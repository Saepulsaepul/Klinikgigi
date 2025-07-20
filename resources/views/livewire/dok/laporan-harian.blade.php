<div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-medical me-2"></i> 
                    @if($reportType === 'daily')
                        Laporan Harian Pemeriksaan
                    @else
                        Laporan Bulanan Pemeriksaan
                    @endif
                </h5>
                <div class="d-flex gap-3 align-items-center">
                    <div class="d-flex align-items-center bg-white rounded px-2 py-1">
                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                        <select wire:model="reportType" class="form-select form-select-sm border-0">
                            <option value="daily">Harian</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>
                    
                    <div class="d-flex align-items-center bg-white rounded px-2 py-1">
                        <i class="fas fa-calendar-day text-muted me-2"></i>
                        @if($reportType === 'daily')
                            <input type="date" wire:model="tanggal" class="form-control form-control-sm border-0">
                        @else
                            <input type="month" wire:model="bulan" class="form-control form-control-sm border-0">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter dan Search -->
            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" wire:model.debounce.300ms="search" 
                                       class="form-control border-0" 
                                       placeholder="Cari pasien (nama/no KTP)...">
                                <button class="btn btn-light border" type="button" 
                                        wire:click="togglePatientSearch"
                                        title="{{ $showAllPatients ? 'Kembali ke laporan' : 'Cari semua pasien' }}">
                                    @if($showAllPatients)
                                        <i class="fas fa-calendar-day me-1"></i> Laporan
                                    @else
                                        <i class="fas fa-users me-1"></i> Pasien
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 text-end">
                    @if($showAllPatients)
                        <div class="form-check form-switch d-inline-block ms-3">
                            <input class="form-check-input" type="checkbox" id="showVisitsOnly" 
                                   wire:model="showVisitsOnly">
                            <label class="form-check-label" for="showVisitsOnly">
                                Hanya yang pernah berkunjung
                            </label>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Pasien</th>
                            <th>No. KTP</th>
                            @if(!$showAllPatients)
                                <th>Diagnosis</th>
                                <th>Kondisi Gigi</th>
                                <th>Tindakan</th>
                                <th>Waktu</th>
                            @else
                                <th>Jumlah Kunjungan</th>
                                <th>Kunjungan Terakhir</th>
                            @endif
                            <th width="100">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$showAllPatients)
                            <!-- Tampilan Laporan Harian/Bulanan -->
                            @forelse($pemeriksaan as $item)
                            <tr>
                                <td>{{ $pemeriksaan->firstItem() + $loop->index }}</td>
                                <td>{{ Str::limit($item->jadwal->patient->nama ?? '-', 30) }}</td>
                                <td>{{ Str::limit($item->jadwal->patient->no_ktp ?? '-', 20) }}</td>
                                <td>{{ Str::limit($item->diagnosis ?? '-', 30) }}</td>
                                <td>
                                    @if($item->kondisiGigi->isNotEmpty())
                                        @php
                                            $kondisiCounts = $item->kondisiGigi->countBy('kondisi');
                                        @endphp
                                        @foreach($kondisiCounts as $kondisi => $count)
                                            <span class="badge bg-{{ $kondisi === 'sehat' ? 'success' : 'danger' }} mb-1">
                                                {{ ucfirst($kondisi) }} ({{ $count }})
                                            </span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($item->kondisiGigi->whereNotNull('tindakan')->isNotEmpty())
                                        @foreach($item->kondisiGigi->pluck('tindakan')->filter()->unique() as $tindakan)
                                            <span class="badge bg-info mb-1">{{ $tindakan }}</span><br>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('H:i') }}</td>
                                <td>
                                    <button wire:click="exportRekamMedis({{ $item->id }})" 
                                            class="btn btn-sm btn-outline-primary"
                                            wire:loading.attr="disabled"
                                            title="Cetak Rekam Medis">
                                        <i class="fas fa-print"></i>
                                        <span wire:loading wire:target="exportRekamMedis({{ $item->id }})" 
                                              class="spinner-border spinner-border-sm"></span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2 text-muted"></i>
                                    <p class="text-muted">
                                        @if($reportType === 'daily')
                                            Tidak ada data pemeriksaan pada tanggal ini
                                        @else
                                            Tidak ada data pemeriksaan pada bulan ini
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        @else
                            <!-- Tampilan Semua Pasien -->
                            @forelse($allPatients as $patient)
                            <tr>
                                <td>{{ $allPatients->firstItem() + $loop->index }}</td>
                                <td>{{ $patient->nama }}</td>
                                <td>{{ $patient->no_ktp }}</td>
                                <td>{{ $patient->examinations_count }}</td>
                                <td>
                                    @if($patient->last_visit)
                                        {{ $patient->last_visit->format('d/m/Y') }}
                                    @else
                                        Belum pernah
                                    @endif
                                </td>
                                <td>
                                    @if($patient->examinations_count > 0)
                                        <button wire:click="viewPatientHistory({{ $patient->id }})" 
                                                class="btn btn-sm btn-outline-info"
                                                title="Lihat Riwayat">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-user-slash fa-2x mb-2 text-muted"></i>
                                    <p class="text-muted">Tidak ada data pasien yang ditemukan</p>
                                </td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan dan Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                @if(!$showAllPatients)
                    <div class="text-muted small">
                        <span class="fw-semibold">{{ $totalPasien }}</span> pasien | 
                        <span class="fw-semibold">{{ $totalTindakan }}</span> tindakan |
                        @foreach($kondisiGigiSummary as $kondisi => $total)
                            <span class="badge bg-{{ $kondisi === 'sehat' ? 'success' : 'danger' }}">
                                {{ ucfirst($kondisi) }}: {{ $total }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted small">
                        Menampilkan <span class="fw-semibold">{{ $allPatients->total() }}</span> pasien
                        @if($showVisitsOnly)
                            yang pernah berkunjung
                        @endif
                    </div>
                @endif
                
                <div>
                    @if(!$showAllPatients)
                        {{ $pemeriksaan->links() }}
                    @else
                        {{ $allPatients->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Riwayat Pasien -->
    @if($viewingPatientHistory)
    <div class="modal fade show" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Riwayat Kunjungan: {{ $selectedPatient?->nama }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" 
                            wire:click="closePatientHistory" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Diagnosis</th>
                                    <th>Tindakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patientHistory as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->diagnosis ?? '-' }}</td>
                                    <td>
                                        @if($history->kondisiGigi->whereNotNull('tindakan')->isNotEmpty())
                                            @foreach($history->kondisiGigi->pluck('tindakan')->filter()->unique() as $tindakan)
                                                <span class="badge bg-info mb-1">{{ $tindakan }}</span><br>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="exportRekamMedis({{ $history->id }})" 
                                                class="btn btn-sm btn-outline-primary"
                                                title="Cetak">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">
                                        Tidak ada riwayat kunjungan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                            wire:click="closePatientHistory">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div>