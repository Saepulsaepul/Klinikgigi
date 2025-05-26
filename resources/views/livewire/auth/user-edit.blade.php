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
                        <h3>Edit User</h3>
                        <p class="text-subtitle text-muted">Data User</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/users">User</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit User -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="update">
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
                            <label class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
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

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary float-end">Update</button>
                            </div>
                        </div>

                        @if (session()->has('message'))
                            <div class="alert alert-success mt-3">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
