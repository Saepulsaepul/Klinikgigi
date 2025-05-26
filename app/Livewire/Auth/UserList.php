<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Title;

class UserList extends Component
{
    #[Title('User List')]
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus!');
        $this->users = User::all(); // Refresh data setelah hapus
    }

    public function render()
    {
        return view('livewire.auth.user');
    }
}
