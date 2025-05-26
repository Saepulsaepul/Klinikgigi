<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;

class ForgotPassword extends Component
{
    #[Layout('components.layouts.auth')]
    public $email;

    public function sendResetLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->dispatch('alert', type: 'success', message: __($status));
        } else {
            session()->flash('error', __($status));
            $this->dispatch('alert', type: 'error', message: __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
