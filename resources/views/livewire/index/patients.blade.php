<div>
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <h4 class="mb-4 text-primary">Data Pasien</h4>
            <!-- Filter and Search Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Cari pasien..." 
                            wire:model.live.debounce.500ms="search"
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" wire:model.live="jenisKelaminFilter">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>No. KTP</th>
                            <th>Jenis Kelamin</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $key => $patient)
                            <tr>
                                <td>{{ $patients->firstItem() + $key }}</td>
                                <td>{{ $patient->nama }}</td>
                                <td>{{ $patient->no_ktp }}</td>
                                <td>{{ $patient->jenis_kelamin }}</td>
                                <td>{{ $patient->no_hp }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pasien.edit', $patient->id) }}" class="btn btn-outline-primary" title="Edit Pasien">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                       
                                        <button 
                                        wire:click="confirmDelete({{ $patient->id }})" 
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada data pasien ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $patients->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" wire:ignore.self id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pasien ini? Data yang dihapus tidak dapat dikembalikan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="deletePatient">
                        <span wire:loading.remove wire:target="deletePatient">Hapus</span>
                        <span wire:loading wire:target="deletePatient">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to handle modal -->
    @push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-toast', (data) => {
            const toast = new bootstrap.Toast(document.getElementById('toastNotification'));
            document.getElementById('toastMessage').innerText = data.message;
            document.getElementById('toastNotification').classList.add(`bg-${data.type}`);
            toast.show();
        });

        Livewire.on('close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            if (modal) modal.hide();
        });

        Livewire.on('showDeleteModal', () => {
            console.log('Event showDeleteModal diterima');
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
</script>
@endpush

</div>