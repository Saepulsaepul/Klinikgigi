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
            <h3>Klinik</h3>
            <p class="text-subtitle text-muted">DataCabang</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Dashboard</a>
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
                    <div class="col-6">
                        <h5 class="card-title">
                            Cabanglist
                        </h5>
                    </div>
                    <div class="col-6">
                        <a wire:navigate href="/cabang/create" class="btn btn-primary float-end">Create cabang</a>

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cabangs as $index => $cabang)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Menambahkan nomor urut -->
                            <td>{{ $cabang->nama }}</td>
                            <td>{{ $cabang->alamat }}</td>
                            <td>{{ $cabang->telepon }}</td>
                            <td>{{ $cabang->email }}</td>
                            <td>
                                <a wire:navigate href="/cabangs/{{$cabang->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <button 
                                wire:click="delete({{$cabang->id}})"
                                wire:confirm='Apakah anda yakin ingin menghapus data ini?'
                                href="#" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
<!-- Basic Tables end -->
</div>
    </div>
</div>
