<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updatePassword">
        <div class="mb-3">
            <label class="form-label">Password Saat Ini</label>
            <div class="position-relative">
                <input wire:model="current_password" type="password" class="form-control" required>
                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('current_password', this)"></i>
            </div>
            @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <div class="position-relative">
                <input wire:model="new_password" type="password" class="form-control" required>
                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('new_password', this)"></i>
            </div>
            @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div class="position-relative">
                <input wire:model="new_password_confirmation" type="password" class="form-control" required>
                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('new_password_confirmation', this)"></i>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                <span wire:loading wire:target="updatePassword">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Memproses...
                </span>
            </button>
        </div>
    </form>
</div>