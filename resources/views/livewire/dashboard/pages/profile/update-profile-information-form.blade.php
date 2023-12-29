<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $username = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->username = Auth::user()->username;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $path = session('url.intended', RouteServiceProvider::HOME);

            $this->redirect($path);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h6 class="fw-semibold">
            <i class='align-middle bx bx-sm bx-id-card me-2'></i>
            {{ __('Profile Information') }}
        </h6>

        <p class="my-2">
            {{ __("panel.UPDATE_PROFILE_TEXT") }}
        </p>
    </header>

    <div class="row">
        <div class="col-12 col-md-6">
            <form wire:submit="updateProfileInformation" class="mt-4 space-y-6">
                <!-- Fullname -->
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Fullname')" />
                    <x-text-input wire:model="name" id="name" name="name" type="text" required
                        autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input wire:model="username" id="username" name="username" type="text" required
                        autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" name="email" type="email" required
                        autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
                            !auth()->user()->hasVerifiedEmail())
                        <div>
                            <p class="mt-2 text-sm text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button wire:click.prevent="sendVerification" class="btn btn-sm btn-dark">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-success">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-dark">{{ __('Save Changes') }}</button>

                    <x-action-message on='profile-updated' class="ms-3" />
                </div>
            </form>
        </div>
    </div>
</section>
