<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;


class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'current_password' => ['required', 'current_password'],
        'new_password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
        ],
    ];

    protected $messages = [
        'current_password.required' => 'Password saat ini harus diisi',
        'current_password.current_password' => 'Password saat ini tidak valid',
        'new_password.required' => 'Password baru harus diisi',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok',
    ];

    public function updatePassword()
    {
        $this->validate();

        try {
            // Update password
            Auth::user()->update([
                'password' => Hash::make($this->new_password)
            ]);

            // Reset form
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

            // Beri feedback ke user
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success', 
                'message' => 'Password berhasil diubah!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.change-password');
    }
}