<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME);
    }
}; ?>

<div>
    <div class="auth-form">
        <div class="mb-4 text-center">
            <a href="{{ route('website') }}">
                <img src="{{ asset('logo.png') }}" width="64" class="mb-3" alt="Perston - Blog Laravel Project">
            </a>

            <h6>{{ __('Welcome!') }} 🎉</h6>
            <p>{{ __('We are happy to have you join us') }}</p>
        </div>

        <form wire:submit="register">
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Fullname')" />
                <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus
                    placeholder="John Doe" autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mb-3">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input wire:model="username" id="username" type="text" name="username" required
                    placeholder="john" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" type="email" name="email" required
                    placeholder="example@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input wire:model="password" id="password" type="password" name="password" required
                    placeholder="********" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password"
                    name="password_confirmation" required placeholder="********" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mb-3 d-flex align-items-center justify-content-end">
                <a class="small" href="{{ route('login') }}" wire:navigate>
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="ms-auto btn btn-sm btn-success">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
