<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h6 class="fw-semibold">
            <i class='align-middle bx bx-sm bx-lock-open-alt me-2'></i>
            {{ __('Update Password') }}
        </h6>

        <p class="my-2">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <div class="row">
        <div class="col-12 col-md-6">
            <form wire:submit="updatePassword" class="mt-4">
                <div class="mb-3">
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                    <x-text-input wire:model="current_password" id="update_password_current_password"
                        name="current_password" type="password" autocomplete="current-password" />
                    @error('current_password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <x-input-label for="update_password_password" :value="__('New Password')" />
                    <x-text-input wire:model="password" id="update_password_password" name="password" type="password"
                        autocomplete="new-password" />
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation"
                        name="password_confirmation" type="password" autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="btn btn-dark">{{ __('Change Password') }}</button>

                    <x-action-message class="ms-3" on="password-updated" />
                </div>
            </form>
        </div>
    </div>
</section>
