<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'pasien'; // Role default 'pasien'

    #[Layout('components.layouts.auth')]  // Layout untuk register
    public function render()
    {
        return view('livewire.auth.register');
    }

    public function register()
    {
        // Validasi data input, tanpa validasi role karena sudah default
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat user baru dengan role otomatis 'pasien'
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role, // Menambahkan role default
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect('/main ');  // Ganti '/login' dengan rute sesuai aplikasimu
    }
}