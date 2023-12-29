<?php

use App\Models\User;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {

    public string $locale = '';

    public string $theme = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->theme = Auth::user()->theme;

        $this->locale = Auth::user()->locale;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateUserSettings(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'locale' => ['required', 'in:en,ar'],
            'theme' => ['required', 'in:light,dark']
        ]);

        $user->update($validated);

        $this->dispatch('update-settings', theme: $user->theme , locale: $user->locale);
    }

}; ?>

<section>
    <header>
        <h6 class="fw-semibold">
            <i class='align-middle bx bx-sm bx-cog me-2'></i>
            {{ __('Settings') }}
        </h6>

        <p class="my-2">
            {{ __("panel.Choose your preferred settings for dashboard.") }}
        </p>
    </header>

    <div class="row">
        <div class="col-12 col-md-6">
            <form wire:submit="updateUserSettings" class="mt-4">
                <!-- Locale -->
                <div class="mb-3">
                    <x-input-label for="locale" value="{{ __('Language') }}" />

                    <select wire:model="locale" id="locale" class="form-select @error('locale') is-invalid  @enderror">
                        <option value="en">{{ __('English') }}</option>
                        <option value="ar">{{ __('Arabic') }}</option>
                    </select>

                    @error('locale')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Theme -->
                <div class="mb-3">
                    <x-input-label for="theme" value="{{ __('Theme Mode') }}" />

                    <select wire:model="theme" id="theme" class="form-select @error('theme') is-invalid  @enderror">
                        <option value="light">{{ __('Light') }}</option>
                        <option value="dark">{{ __('Dark') }}</option>
                    </select>

                    @error('theme')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-dark">{{ __('Submit') }}</button>

                    <x-action-message on='update-settings' class="ms-2" />
                </div>
            </form>
        </div>
    </div>
</section>
