<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(session('url.intended', RouteServiceProvider::HOME));
    }
}; ?>


<div>
    <div class="auth-form">
        <div class="mb-4 text-center">
            <a href="{{ route('website') }}">
                <img src="{{ asset('logo.png') }}" width="64" class="mb-3" alt="Perston - Blog Laravel Project">
            </a>

            <h6>{{ __('Welcome! Back') }} 🤗</h6>
            <p>{{ __('Please, Tell me who you are?') }}</p>
        </div>

        <form wire:submit="login">
            <!-- Email Address -->
            <div>
                <x-input-label for="user_name" :value="__('Email\Username')" />
                <x-text-input wire:model="form.user_name" id="user_name" type="text" name="user_name" required autofocus
                    autocomplete="username" />
                @error('user_name')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <x-input-label for="password" :value="__('Password')" class="me-auto" />

                    @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                </div>

                <x-text-input wire:model="form.password" id="password" type="password" name="password" required
                    autocomplete="current-password" />
                @error('password')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember" class="form-check-label">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input"
                        name="remember">
                    <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4 d-flex align-items-center justify-content-end">
                <p class="small me-auto">
                    {{ __('Don\'t have account?') }}
                    <a href="{{ route('register') }}" class="text-success fw-semibold">{{ __('Sign Up') }}</a>
                </p>

                <button type="submit" class="btn btn-dark">
                    {{ __('Sign In') }}
                </button>
            </div>


            <hr>

            <table class="table table-bordered table-sm small">
                <thead class="bg-light">
                    <tr>
                        <th>{{ __('For') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Password') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Owner</td>
                        <td>owner</td>
                        <td>password</td>
                    </tr>
                    <tr>
                        <td>Super Admin</td>
                        <td>superadmin</td>
                        <td>password</td>
                    </tr>
                    <tr>
                        <td>Admin</td>
                        <td>admin</td>
                        <td>password</td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
