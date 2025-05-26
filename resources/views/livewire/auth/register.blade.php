<div>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <form wire:submit.prevent='register' class="bg-white border p-3 rounded d-grid mx-auto pb-4" style="width: 325px; height: auto;">
            <img src="./assets/compiled/jpg/GIGI.jpg" class="img-fluid mx-auto mb-4 mt-2" style="width: 100px;" alt="register">
            
            <div class="form-group position-relative has-icon-left mb-4">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input wire:model='name' type="text" class="form-control form-control-xl" placeholder="Nama Lengkap">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>

            <div class="form-group position-relative has-icon-left mb-4">
                <label for="email" class="form-label">Email</label>
                <input wire:model='email' type="email" class="form-control form-control-xl" placeholder="Email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-envelope"></i>
                </div>
            </div>

            <div class="form-group position-relative has-icon-left mb-4">
                <label for="password" class="form-label">Password</label>
                <input wire:model='password' type="password" class="form-control form-control-xl" placeholder="Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-lock"></i>
                </div>
            </div>

            <div class="form-group position-relative has-icon-left mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input wire:model='password_confirmation' type="password" class="form-control form-control-xl" placeholder="Konfirmasi Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>

            <button class="btn btn-success btn-block btn-lg shadow-lg mt-3 d-flex justify-content-center align-items-center gap-2" type="submit" wire:target="register" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Registrasi</span>
                <img wire:loading wire:target="register" src="./assets/compiled/svg/circles.svg" alt="Loading..." style="width: 1.5rem; height: 1.5rem;">
            </button>

            <div class="text-center mt-3">
                <span>Sudah punya akun? <a href="/login" class="text-decoration-none">Login</a></span>
            </div>
        </form>
    </div>
</div>
