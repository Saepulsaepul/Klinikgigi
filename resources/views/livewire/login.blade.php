<div>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <form wire:submit.prevent='login'
              class="bg-white border p-3 rounded d-grid mx-auto pb-4"
              style="width: 325px; height: auto;">
              
            {{-- Flash Messages --}}
            @if (session()->has('success'))
                <div class="alert alert-success text-center mb-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

            @if (session()->has('error'))
                <div class="alert alert-danger text-center mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <img src="./assets/compiled/jpg/GIGI.jpg" class="img-fluid mx-auto mb-4 mt-2" style="width: 100px;" alt="login">
            
            <div class="form-group position-relative has-icon-left mb-4">
                <label for="exampleinputEmail" class="form-label">Masukan Email</label>
                <input wire:model='email' type="text" class="form-control form-control-xl" placeholder="Email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            
            <div class="form-group position-relative has-icon-left mb-4">
                <label for="exampleinputPassword" class="form-label">Password</label>
                <input wire:model='password' type="password" class="form-control form-control-xl" placeholder="Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror 
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>

            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3 d-flex justify-content-center align-items-center gap-2"
                    type="submit"
                    wire:target="login"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">Login</span>
                <img wire:loading wire:target="login" src="./assets/compiled/svg/circles.svg" alt="Loading..." style="width: 1.5rem; height: 1.5rem;">
            </button>

            <div class="text-center mt-3">
                <a href="/fargot-password" class="text-decoration-none">Lupa Password?</a>
            </div>
            <div class="text-center mt-2">
                <span>Belum punya akun? <a href="/register" class="text-decoration-none">Registrasi</a></span>
            </div>
        </form>
    </div>
</div>
