<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    #[Title('Login')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        // Tambahan: Buat data pasien jika belum ada
    $user = Auth::user();

    if (! $user->patient) {
        \App\Models\Patient::create([
            
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'no_hp' => null,
            'jenis_kelamin' => null,
            'alamat' => null,
        ]);
    }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
