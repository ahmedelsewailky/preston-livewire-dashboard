<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;
use App\Livewire\Actions\Logout;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
}; ?>

<aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" data-bs-scroll="false">
    <!-- Brand -->
    <div class="sidebar-brand">
        <h1>
            <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
        </h1>
    </div>

    <!-- Authenticate -->
    <div class="sidebar-auth">
        <div class="d-flex justify-content-center">
            <a href="{{ route('profile') }}" class="mx-2 p-2 small text-center {{ Request::routeIs('profile') ? 'active' : false }}">
                <i class="mb-2 bx bx-user d-block"></i> {{ __('Profile') }}
            </a>
            <a href="{{ route('profile') }}#settings" class="p-2 mx-2 text-center small">
                <i class="mb-2 bx bx-cog d-block"></i> {{ __('Settings') }}
            </a>
            <a href="" class="p-2 mx-2 text-center small" wire:click.prevent='logout' title="Logout">
                <i class="mb-2 bx bx-log-out-circle d-block"></i> {{ __('Logout') }}
            </a>
        </div>
    </div>

    <!-- Menu -->
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <h6>{{ __('Basic') }}</h6>
            <li class="nav-item">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <span class="nav-link-icon">
                        <i class="bx bx-tachometer"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Dashboard') }}</span>
                </x-nav-link>
            </li>

            <h6>{{ __('Navigate') }}</h6>
            <li class="nav-item">
                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                    <span class="nav-link-icon">
                        <i class="bx bx-edit"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Posts') }}</span>
                </x-nav-link>
            </li>
            <li class="nav-item">
                <x-nav-link :href="route('category')" :active="request()->routeIs('category')">
                    <span class="nav-link-icon">
                        <i class="bx bx-category"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Categories') }}</span>
                </x-nav-link>
            </li>
            <li class="nav-item">
                <x-nav-link :href="route('tag')" :active="request()->routeIs('tag')">
                    <span class="nav-link-icon">
                        <i class="bx bx-tag"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Tags') }}</span>
                </x-nav-link>
            </li>
            <li class="nav-item">
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    <span class="nav-link-icon">
                        <i class="bx bx-user"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Users') }}</span>
                </x-nav-link>
            </li>

            <h6>{{ __('Pages & Apps') }}</h6>
            <li class="nav-item">
                <x-nav-link :href="route('messenger')" :active="request()->routeIs('messenger')">
                    <span class="nav-link-icon">
                        <i class="bx bx-chat"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Chat') }}</span>
                </x-nav-link>
            </li>
            <li class="nav-item">
                <x-nav-link :href="route('calendar')" :active="request()->routeIs('calendar')">
                    <span class="nav-link-icon">
                        <i class="bx bx-calendar"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Calendar') }}</span>
                </x-nav-link>
            </li>

            <h6>{{ __('Misc') }}</h6>
            <li class="nav-item">
                <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.*')">
                    <span class="nav-link-icon">
                        <i class="bx bx-package"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Roles') }}</span>
                </x-nav-link>
            </li>
            <li class="nav-item">
                <x-nav-link :href="route('permission')" :active="request()->routeIs('permission')">
                    <span class="nav-link-icon">
                        <i class="bx bx-shield-plus"></i>
                    </span>
                    <span class="nav-link-text">{{ __('Permissions') }}</span>
                </x-nav-link>
            </li>
        </ul>
    </div>
</aside>
