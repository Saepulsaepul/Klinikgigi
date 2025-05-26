<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Title('Login')]
    #[Layout('components.layouts.auth')]

    #[Validate('email')]
    public $email;

    #[Validate('required', message: 'Field tidak boleh kosong')]
    public $password;

    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user(); // Ambil data user yang berhasil login

            session()->flash('success', 'Login berhasil!');

            // Trigger event Livewire jika perlu
            $this->dispatch('login-success', message: 'Login berhasil!');

            // Cek role dan redirect sesuai peran
            if ($user->role === 'admin') {
                return redirect()->to('/dashboard');  // Redirect untuk admin
            } elseif ($user->role === 'pasien') {
                return redirect()->to('/main');
            } elseif ($user->role === 'dokter') {
                return redirect()->to('/dok-dashboard');  // Redirect untuk dokter
            } elseif ($user->role === 'resepsionis') {
                return redirect()->to('/receptionist-dashboard');  // Redirect untuk perawat
             // Redirect untuk pasien
            } else {
                // Fallback jika role tidak dikenali
                Auth::logout();  // Logout paksa
                session()->flash('error', 'Role tidak dikenali!');
                return;  // Menghentikan eksekusi lebih lanjut
            }
        } else {
            // Jika email atau password salah
            session()->flash('error', 'Email atau password salah.');
            $this->dispatch('login-error', message: 'Email atau password salah!');
        }
    }
}
