<div class="d-flex justify-content-center align-items-center vh-100">
    <form wire:submit.prevent='sendResetLink' class="bg-white border p-4 rounded d-grid mx-auto" style="width: 350px;">
        <h4 class="text-center mb-4">Lupa Password</h4>
        <p class="text-center mb-3">Masukkan email Anda untuk mendapatkan link reset password.</p>

        @if (session()->has('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="form-group position-relative has-icon-left mb-4">
            <label for="email" class="form-label">Email</label>
            <input wire:model='email' type="email" class="form-control form-control-xl" placeholder="Email" required>
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
            @error('email') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3" type="submit">
            Kirim Link Reset
        </button>

        <div class="text-center mt-3">
            <a href="/login" class="text-decoration-none">Kembali ke Login</a>
        </div>
    </form>
</div>
