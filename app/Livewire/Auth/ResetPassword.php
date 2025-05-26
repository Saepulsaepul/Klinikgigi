<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class ResetPassword extends Component
{
    #[Layout('components.layouts.auth')]
    public string $token;
public ?string $email = null;
public string $password = '';
public string $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email'); // Auto-fill dari URL
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('status', 'Password berhasil direset. Silakan login.');
            return redirect()->route('login');
        } else {
            session()->flash('error', 'Reset password gagal. Token atau email tidak valid.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
