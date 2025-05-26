<div class="card shadow rounded p-4">
    <h4 class="mb-4 text-primary">Form Booking Jadwal Pemeriksaan</h4>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <!-- Nama Pasien -->
        <div class="mb-3">
            <label class="form-label">Nama Pasien</label>
            <input type="text" class="form-control shadow-sm" value="{{ Auth::user()->name }}" disabled>
        </div>

        <!-- Tanggal dan Jam -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                <input type="date" wire:model="tanggal" 
                       class="form-control shadow-sm @error('tanggal') is-invalid @enderror"
                       min="{{ now()->format('Y-m-d') }}">
                @error('tanggal') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Jam Pemeriksaan <span class="text-danger">*</span></label>
                <input type="time" wire:model="jam" 
                       class="form-control shadow-sm @error('jam') is-invalid @enderror">
                @error('jam') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Dropdown Dokter -->
        <div class="mb-3">
            <label class="form-label">Dokter <span class="text-danger">*</span></label>
            <select wire:model="dokter" class="form-select shadow-sm @error('dokter') is-invalid @enderror" required>
                <option value="">Pilih Dokter</option>
                <option value=" Drg.Ahmad Efendi.AMK.SPDI "> Drg.Ahmad Efendi.AMK.SPDI </option>
                {{-- <option value="Dr. Budi">Dr. Budi</option>
                <option value="Dr. Citra">Dr. Citra</option> --}}
            </select>
            @error('dokter') 
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Keterangan -->
        <div class="mb-4">
            <label class="form-label">Keterangan Tambahan</label>
            <textarea wire:model="keterangan" 
                     class="form-control shadow-sm @error('keterangan') is-invalid @enderror" 
                     rows="3"
                     placeholder="Gejala atau keluhan yang dirasakan"></textarea>
            @error('keterangan') 
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="fas fa-calendar-plus me-2"></i> Booking Jadwal
            </span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Memproses...
            </span>
        </button>
    </form>
</div>