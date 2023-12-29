<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="auth-form">
        <div class="mb-4 text-center">
            <a href="{{ route('website') }}">
                <img src="{{ asset('logo.png') }}" width="64" class="mb-3" alt="Perston - Blog Laravel Project">
            </a>

            <h6>{{ __('Forgot your password') }}! 😊</h6>
            <p class="mt-2">
                {{ __('FORGET_PASSWORD_MESSAGE') }}
            </p>
        </div>

        <form wire:submit="sendPasswordResetLink">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mt-3 mb-0 alert alert-warning">
                    {{ session('status') }}
                </div>
            @endif

            <div>
                <button type="submit" class="mt-3 btn btn-success">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>


</div>
