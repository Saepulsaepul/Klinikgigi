<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Cabang;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserEdit extends Component
{
    #[Title('Edit User')]
    public $userId, $name, $email, $cabang_id, $role;
    public $cabangs;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->cabang_id = $user->cabang_id;
        $this->role = $user->role;

        // Ambil daftar cabang untuk dropdown
        $this->cabangs = Cabang::all();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'cabang_id' => 'required|exists:cabangs,id',
            'role' => 'required|in:admin,resepsionis,dokter,pasien',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'cabang_id' => $this->cabang_id,
            'role' => $this->role,
        ]);

        session()->flash('message', 'User berhasil diperbarui!');

        return redirect('/users')->with('message', 'User berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.auth.user-edit');
    }
}
