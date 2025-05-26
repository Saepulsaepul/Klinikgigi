<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Layout;

class UserProfile extends Component
{
    public $user;
    public $showModal = false;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $this->user = User::with('cabang')->find(Auth::id());
    }
    public function openModal() {
        $this->showModal = true;
    }
    
    protected $listeners = ['profileUpdated' => 'openModal'];

    public function render()
    {
        return view('livewire.auth.user-profile');
    }
}
