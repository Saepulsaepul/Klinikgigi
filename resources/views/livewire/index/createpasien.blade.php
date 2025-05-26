<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 text-primary">
            <i class="fas fa-user-{{ $isEditing ? 'edit' : 'plus' }} me-2"></i>
            {{ $isEditing ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}
        </h2>
        <a href="{{ route('receptionist-dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0"><i class="fas fa-user-circle me-2"></i>Formulir Pendaftaran Pasien</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" wire:model="nama" class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor KTP</label>
                        <input type="text" wire:model="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror">
                        @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                        <input type="text" wire:model="no_hp" class="form-control @error('no_hp') is-invalid @enderror">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select wire:model="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" wire:model="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Cabang <span class="text-danger">*</span></label>
                        <select wire:model="cabang_id" class="form-select @error('cabang_id') is-invalid @enderror">
                            <option value="">Pilih Cabang</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                            @endforeach
                        </select>
                        @error('cabang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea wire:model="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"></textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end">
                            <button type="button" wire:click="$reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                                 <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> {{ $isEditing ? 'Perbarui Pasien' : 'Simpan Pasien' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>