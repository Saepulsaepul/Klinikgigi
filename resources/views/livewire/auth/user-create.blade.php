<div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        
<div class="page-heading">
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Create User</h3>
            <p class="text-subtitle text-muted">Datauser</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a wire:navigate href="/dashboard">Dashboard</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="card-title">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <form wire:submit.prevent="create">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" wire:model="name">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" wire:model="password">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label class="form-label">Cabang</label>
                                    <select class="form-select" wire:model="cabang_id">
                                        <option value="">Pilih Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('cabang_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-select" wire:model="role">
                                        <option value="">Pilih Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="resepsionis">Resepsionis</option>
                                        <option value="dokter">Dokter</option>
                                    </select>
                                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row mb-6">
                                    <div class="col-sm-12 text-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                
                            </form>
                        
                            @if (session()->has('message'))
                                <div class="alert alert-success mt-3">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                        
                
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</section>
<!-- Basic Tables end -->
</div>
    </div>
</div>
