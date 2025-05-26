<div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-medical me-2"></i> Laporan Harian Pemeriksaan
                </h5>
                <div class="d-flex gap-2 align-items-center ">
                    <input type="date" wire:model="tanggal" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter dan Pagination -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" wire:model.debounce.300ms="search" 
                           class="form-control" placeholder="Cari pasien (nama/no KTP)...">
                </div>
                {{-- <div class="col-md-6 text-end">
                    <select wire:model="perPage" class="form-select form-select-sm d-inline-block w-auto">
                        <option value="10">10 per halaman</option>
                        <option value="25">25 per halaman</option>
                        <option value="50">50 per halaman</option>
                    </select>
                </div> --}}
            </div>

            <!-- Tabel Data Pemeriksaan -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Pasien</th>
                            <th>No. KTP</th>
                            <th>Diagnosis</th>
                            <th>Kondisi Gigi</th>
                            <th>Tindakan</th>
                            <th>Waktu</th>
                            <th width="100">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
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
                                <p class="text-muted">Tidak ada data pemeriksaan pada tanggal ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan dan Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    <span class="fw-semibold">{{ $totalPasien }}</span> pasien | 
                    <span class="fw-semibold">{{ $totalTindakan }}</span> tindakan |
                    @foreach($kondisiGigiSummary as $kondisi => $total)
                        <span class="badge bg-{{ $kondisi === 'sehat' ? 'success' : 'danger' }}">
                            {{ ucfirst($kondisi) }}: {{ $total }}
                        </span>
                    @endforeach
                </div>
                <div>
                    {{ $pemeriksaan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>