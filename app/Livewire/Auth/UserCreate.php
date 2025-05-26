<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Cabang;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserCreate extends Component
{
    #[Title('Tambah User')]
    public $name, $email, $password, $cabang_id, $role; // Tambahkan $role
    public $cabangs;

    public function mount()
    {
        $this->cabangs = Cabang::all(); // Ambil semua cabang untuk dropdown
        $this->role = ''; // Inisialisasi agar tidak null
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'cabang_id' => 'required|exists:cabangs,id',
            'role' => 'required|in:admin,resepsionis,dokter,pasien', // Pastikan role masuk dalam validasi
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'cabang_id' => $this->cabang_id,
            'role' => $this->role, 
        ]);

        // session()->flash('message', 'User berhasil ditambahkan!');
        
        return redirect('/users')->with('message', 'User berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.auth.user-create');
    }
}
