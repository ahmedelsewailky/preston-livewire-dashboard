<x-app-layout>
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
    </x-slot>

    <div class="container">
        <div class="mb-3 card">
            <div class="card-body">
                <livewire:profile.update-image />
            </div>
        </div>

        <div class="mb-3 card">
            <div class="card-body">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="mb-3 card">
            <div class="card-body">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="mb-3 card" id="settings">
            <div class="card-body">
                <livewire:profile.update-settings />
            </div>
        </div>
    </div>
</x-app-layout>
