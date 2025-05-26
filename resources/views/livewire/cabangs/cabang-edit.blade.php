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
            <h3>Edit Cabang</h3>
            <p class="text-subtitle text-muted">DataCabang</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle text-decoration-none" href="#" role="button" id="breadcrumbDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Layout Default
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="breadcrumbDropdown">
                            <li><a class="dropdown-item" href="#">Layout 1</a></li>
                            <li><a class="dropdown-item" href="#">Layout 2</a></li>
                            <li><a class="dropdown-item" href="#">Layout 3</a></li>
                        </ul>
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
                        <form wire:submit.prevent='update'>
                            <div class="row mb-3">
                              <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <input wire:model="nama" type="text" class="form-control">
                                @error('nama')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label for="inputText" class="col-sm-2 col-form-label">Phone</label>
                              <div class="col-sm-10">
                                <input wire:model="telepon" type="text" class="form-control">
                                @error('telepon')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <input wire:model="email"type="email" class="form-control">
                                @error('email')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                  <textarea wire:model="alamat" class="form-control" style="height: 100px"></textarea>
                                  @error('alamat')
                                  <div class="text-danger">{{$message}}</div>
                                  @enderror
                                </div>
                
                            <div class="row mb-3">
                              <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary float-end">Create</button>
                              </div>
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
