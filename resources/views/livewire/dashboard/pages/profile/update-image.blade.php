<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\{Auth, Storage};

new class extends Component {
    use WithFileUploads;

    public $image = '';

    public $imageInput = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->image = Auth::user()->image ? Auth::user()->image : '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileImageAvatar(): void
    {
        $user = Auth::user();

        $this->validate([
            'imageInput' => ['required', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
        ]);

        if ($this->image) {
            $this->deleteImageIfExists();
        }

        $this->image = $this->imageInput->store('users', 'public');

        $user->update([
            'image' => $this->image
        ]);

        $this->reset('imageInput');

        $this->dispatch('profile-updated', image: $user->image);
    }

    private function deleteImageIfExists(): void
    {
        if (Storage::exists('public/' . $this->image)) {
            Storage::delete('public/' . $this->image);
        }
    }

}; ?>

<section>
    <header>
        <h6 class="fw-semibold">
            <i class='align-middle bx bx-sm bx-image-alt me-2'></i>
            {{ __('Profile Image Avatar') }}
        </h6>

        <p class="my-2">
            {{ __("panel.Update your account's profile image.") }}
        </p>
    </header>

    <div class="row">
        <div class="col-12 col-md-6">
            <form wire:submit="updateProfileImageAvatar" class="mt-4">
                @if ($imageInput)
                    <img src="{{ $imageInput->temporaryUrl() }}" width="100" height="100" class="mb-4 rounded-circle"  alt="temporary image">
                @else
                    @if ($image)
                        <img src="{{ asset('storage\\') . $image}}" width="100" height="100" class="mb-4 rounded-circle"  alt="">
                    @else
                        <img src="{{ asset('dashboard/images/avatars/user-2.png') }}" class="mb-4" alt="{{ auth()->user()->username }}">
                    @endif
                @endif

                <div class="my-3" wire:loading wire:target='imageInput'>{{ __('loading ....') }}</div>

                <!-- Image -->
                <div class="mb-3">
                    <x-text-input wire:model="imageInput" id="imageInput" name="imageInput" type="file"
                        accept="image/jpg,image/png,image/jpeg" />
                    @error('imageInput')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-dark">{{ __('Update Image') }}</button>

                    <x-action-message on='profile-updated' class="ms-3" />
                </div>
            </form>
        </div>
    </div>
</section>
