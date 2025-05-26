<div class="container d-flex justify-content-center align-items-center vh-100">
    <form wire:submit.prevent='resetPassword' class="bg-white border p-4 rounded" style="width: 350px;">
        <h4 class="text-center mb-4">Reset Password</h4>

        @if (session()->has('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <label>Email</label>
            <input type="email" wire:model="email" class="form-control" readonly required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" wire:model="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" wire:model="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
    </form>
</div>
