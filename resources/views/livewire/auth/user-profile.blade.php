<div class="container mt-4">
    <!-- Logo di tengah -->
    <div class="text-center mb-3 ">
        <img src="{{ asset('./assets/compiled/jpg/GIGI.jpg') }}" alt="Logo Klinik" style="max-height: 100px;">
    </div>

    <!-- Kartu profil -->
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-header text-center animate-card">
            <h4>Profil Pengguna</h4>
        </div>
        <div class="card-body rounded-4 animate-card"> 
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width: 30%;">Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Cabang</th>
                    <td>{{ $user->cabang?->nama ?? 'Tidak Ada Cabang' }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
