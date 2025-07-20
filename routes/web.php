<?php

use App\Http\Livewire\Receptionist\Createpasien;
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
use App\Livewire\Dokter\DokterForm;
use App\Livewire\Index\Createpasien as IndexCreatepasien;
use App\Livewire\Index\Patients;
use App\Livewire\Index\ReseptionistDashboard;
use App\Livewire\Layout\Utama;
use App\Livewire\Login;
use App\Livewire\Main\BuatJadwal;
use App\Livewire\Main\Index;
use App\Livewire\Main\Jadwal;
use App\Livewire\NotFound;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Redirect to login if not authenticated
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
Route::get('/register', Register::class)->name('register');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile accessible to all authenticated users
    Route::get('/profile', App\Livewire\Auth\UserProfile::class)->name('profile');

    // Admin routes
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('/dashboard', Dashboard::class);
        
        Route::get('/cabangs', CabangIndex::class);
        Route::get('/cabang/create', CabangCreate::class);
        Route::get('/cabangs/{id}/delete', [CabangIndex::class, 'delete']);
        Route::get('/cabangs/{id}/edit', CabangEdit::class);
        
        Route::get('/users', UserList::class);
        Route::get('/users/create', UserCreate::class);
        Route::get('/users/{id}/delete', [UserList::class, 'delete']);
        Route::get('/users/{id}/edit', UserEdit::class)->name('user.edit');
        
        Route::get('/dokter/create', DokterForm::class)->name('dokter.create');
    });

    // Doctor routes
    Route::middleware('can:isDokter')->group(function () {
        Route::get('/dok-dashboard', App\Livewire\Dok\DokDashboard::class)->name('dok-dashboard');
        Route::get('/dok-pemeriksaan', App\Livewire\Dok\Pemeriksaan::class)->name('dok-pemeriksaan');
        Route::get('/odontogram', App\Livewire\Dok\Odontogram::class)->name('odontogram');
        Route::get('/laporan-harian', App\Livewire\Dok\LaporanHarian::class)->name('laporan-harian');
    });

    // Receptionist routes
    Route::middleware('can:isResepsionis')->group(function () {
        Route::get('/receptionist-dashboard', ReseptionistDashboard::class)->name('receptionist-dashboard');
        Route::get('/reseptionist-patients', Patients::class)->name('reseptionist-patients');
        Route::get('/pasien/create', IndexCreatepasien::class)->name('pasien.create');
        Route::get('/pasien/{id}/edit', IndexCreatepasien::class)->name('pasien.edit');
    });

    // Patient routes
    Route::middleware('can:isPasien')->group(function () {
        Route::get('/main', Index::class)->name('Index');
        Route::get('/buat-jadwal', BuatJadwal::class)->name('buat-jadwal');
    });

    // Logout route
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// Fallback route for 404 errors
Route::fallback(NotFound::class);