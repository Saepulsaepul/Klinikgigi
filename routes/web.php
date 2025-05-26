<?php


use App\Http\Livewire\Receptionist\Createpasien;
use App\Livewire\Auth\Fargotpassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\UserCreate;
use App\Livewire\Auth\UserEdit;
use App\Livewire\Auth\UserList;
use App\Livewire\Cabangs\CabangCreate;
use App\Livewire\Cabangs\CabangEdit;
use App\Livewire\Cabangs\CabangIndex;

use App\Livewire\Dashboard;
use App\Livewire\Cabangs\DokterForm as DokterDokterForm;
use App\Livewire\Dokter\DokterForm;
use App\Livewire\Index\Createpasien as IndexCreatepasien;
use App\Livewire\Index\Patients;
use App\Livewire\Index\ReseptionistDashboard;
use App\Livewire\Login;
use App\Livewire\Main\BuatJadwal;
use App\Livewire\Main\Index;
use App\Livewire\Main\Jadwal;
use App\Livewire\NotFound;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use LDAP\Result;

// Redirect ke login kalau belum login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman login & lupa password
Route::get('/login', Login::class)->name('login');
Route::get('/fargot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
Route::get('/register', Register::class)->name('register');
// Halaman admin (hanya bisa diakses kalau sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class);
    Route::get('/cabangs', CabangIndex::class);
    Route::get('/cabang/create', CabangCreate::class);
    Route::get('/cabangs/{id}/delete', [CabangIndex::class, 'delete']);
    Route::get('/cabangs/{id}/edit', CabangEdit::class);
    

    

    Route::get('/users', UserList::class);
    Route::get('/users/create', UserCreate::class);
    Route::get('/users/{id}/delete', [UserList::class, 'delete']);
    Route::get('/users/{id}/edit', UserEdit::class)->name('user.edit');
    Route::middleware('auth')->group(function () {
    Route::get('/profile', App\Livewire\Auth\UserProfile::class)->name('profile') ->middleware('auth');
    });

    //halamana pasien
Route::get('/main ', Index::class)->name('Index');
Route::get('/buat-jadwal ', BuatJadwal::class)->name('buat-jadwal');


//halaman dokter
Route::get('/dok-dashboard', App\Livewire\Dok\DokDashboard::class)->name('dok-dashboard');
Route::get('/dok-pemeriksaan', App\Livewire\Dok\Pemeriksaan::class)->name('dok-pemeriksaan');
Route::get('/odontogram', App\Livewire\Dok\Odontogram::class)->name('odontogram');
Route::get('/dokter/create', App\Livewire\Dokter\DokterForm::class)->name('dokter.create');
Route::get('/laporan-harian', App\Livewire\Dok\LaporanHarian::class)->name('laporan-harian');




//halaman reseptionis
Route::get('/receptionist-dashboard', ReseptionistDashboard::class)->name('receptionist-dashboard');
Route::get('/reseptionist-patients', Patients::class)->name('reseptionist-patients');
Route::get('/pasien/create', IndexCreatepasien::class)->name('pasien.create');
Route::get('/pasien/{id}/edit', IndexCreatepasien::class)->name('pasien.edit');
     // Logout menggunakan POST
     Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// Halaman fallback (404)
Route::fallback(NotFound::class);





