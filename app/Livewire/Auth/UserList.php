<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]

class UserList extends Component
{
    
    #[Title('User Management')]
    public $showPasien = false; // Property untuk toggle tampilan pasien
    
    public function mount()
    {
        // Tidak perlu load data di sini, akan dihandle di render()
    }

    public function togglePasien()
    {
        $this->showPasien = !$this->showPasien;
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus!');
        // Tidak perlu refresh data manual, Livewire akan auto re-render
    }

    public function render()
    {
        // Load semua user dengan relasi cabang
        $users = User::with('cabang')->get();
        
        return view('livewire.auth.user', [
            'users' => $users,
            'showPasien' => $this->showPasien
        ]);
    }
}