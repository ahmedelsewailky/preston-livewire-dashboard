<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public string $name;
    public $image;

    #[On('profile-updated')]
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->image = auth()->user()->image;
    }

    /**
     * Switch auth prefered locale for dashboard
     *
     * @return void
     **/
    public function updateLocale()
    {
        $user = auth()->user();
        $locale = $user->locale == 'ar' ? 'en' : 'ar';
        $user->update(['locale' => $locale]);
        // $this->dispatch('update-settings', locale: $user->locale, theme: $user->theme);
        return $this->redirect(request()->header('Referer'));
    }

    /**
     * Switch auth prefered theme for dashboard
     *
     * @return void
     **/
    public function updateTheme()
    {
        $user = auth()->user();
        $theme = $user->theme == 'light' ? 'dark' : 'light';
        $user->update(['theme' => $theme]);
        $this->dispatch('update-settings', theme: $user->theme, locale: $user->locale);
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
}; ?>
<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigationBar"
                aria-controls="mainNavigationBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavigationBar">
                <button type="button" class="toggler-sidebar d-block d-md-none" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebar">
                    <i class="bx bx-menu-alt-left"></i>
                </button>

                <form action="">
                    <input type="text" name="q" placeholder="{{ __('Search') }}">
                    <button type="submit"><i class="bx bx-search"></i></button>
                </form>

                <ul class="mb-2 navbar-nav ms-auto align-items-center mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" wire:click.prevent="updateLocale">
                            <i class="bx bx-globe"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" wire:click.prevent="updateTheme"><i
                                class="bx bx-{{ auth()->user()->theme == 'dark' ? 'sun' : 'moon' }}"></i></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-icon {{ Request::routeIs('messenger') ? 'active' : '' }}"
                            href="{{ route('messenger') }}"><i class="bx bx-chat"></i></a>
                    </li>

                    <!-- Quick Links -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside" href="#">
                            <i class='bx bx-category-alt'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mega-menu app-menu">
                            <h6>{{ __('Quick Links') }}</h6>

                            <div class="row g-0">
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://facebook.com/ahmedelsewailky" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/facebook.png') }}"
                                                alt="Facebook">
                                            <span class="mt-1 text-capitalize">{{ __('Facebook') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://twitter.com/elsewailky" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/twitter.png') }}"
                                                alt="Twitter">
                                            <span class="mt-1 text-capitalize">{{ __('Twitter') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://youtube.com/" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/youtube.png') }}"
                                                alt="youtube">
                                            <span class="mt-1 text-capitalize">{{ __('youtube') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://instagram.com/elsewailky" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/instagram.png') }}"
                                                alt="instagram">
                                            <span class="mt-1 text-capitalize">{{ __('instagram') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://github.com/ahmedelsewailky" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/github.png') }}"
                                                alt="github">
                                            <span class="mt-1 text-capitalize">{{ __('github') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="app-item">
                                        <a href="https://www.linkedin.com/in/ahmed-elsewailky-a83882144/" target="_blank">
                                            <img src="{{ asset('dashboard/images/icons/linkedin.png') }}"
                                                alt="linkedin">
                                            <span class="mt-1 text-capitalize">{{ __('linkedin') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- ./Quick Links -->

                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-bell"></i>
                            {{-- <span class="count-label">3</span> --}}
                            <i class='bx bxs-circle bx-flashing bx-flip-horizontal icon-puls text-success'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mega-menu notification-menu">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('Notifications') }}</h6>
                                <a href="" class="small text-primary">{{ __('Mark all as read') }}</a>
                            </div>
                            <div style="height: 293px">
                                <div class="d-flex unread">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-5.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-2.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-3.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex unread">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-4.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-6.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- ./Notifications -->

                    <!-- Auth -->
                    <li class="nav-item">
                        <div class="nav-link">
                            <div class="d-flex align-items-center auth-menu">
                                <div class="flex-grow-1 text-end">
                                    <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                                    <span>{{ auth()->user()->getRoleNames()[0] }}</span>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    @if ($image)
                                        <img src="{{ asset('storage\\') . $image }}" width="35"
                                            class="rounded-circle" alt="{{ auth()->user()->name }}">
                                    @else
                                        <img src="{{ asset('dashboard/images/avatars/user-1.png') }}" width="35"
                                            alt="{{ auth()->user()->name }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- ./Auth -->
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg mobile-navbar">
        <div class="container-fluid">
            <ul class="mb-2 navbar-nav mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link toggler-sidebar nav-link-icon" href="javascript:void(0)" data-bs-toggle="offcanvas"
                        data-bs-target="#sidebar">
                        <i class="bx bx-menu-alt-left"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="#" wire:click.prevent="updateLocale">
                        <i class="bx bx-globe"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="#" wire:click.prevent="updateTheme"><i
                            class="bx bx-{{ auth()->user()->theme == 'dark' ? 'sun' : 'moon' }}"></i></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-icon {{ Request::routeIs('messenger') ? 'active' : '' }}"
                        href="{{ route('messenger') }}"><i class="bx bx-chat"></i></a>
                </li>

                <!-- Quick Links-->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside" href="#">
                        <i class='bx bx-category-alt'></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end mega-menu app-menu">
                        <h6>{{ __('Quick Links') }}</h6>

                        <div class="row g-0">
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://facebook.com/ahmedelsewailky" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/facebook.png') }}"
                                            alt="Facebook">
                                        <span class="mt-1 text-capitalize">{{ __('Facebook') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://twitter.com/elsewailky" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/twitter.png') }}"
                                            alt="Twitter">
                                        <span class="mt-1 text-capitalize">{{ __('Twitter') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://youtube.com/" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/youtube.png') }}"
                                            alt="youtube">
                                        <span class="mt-1 text-capitalize">{{ __('youtube') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://instagram.com/elsewailky" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/instagram.png') }}"
                                            alt="instagram">
                                        <span class="mt-1 text-capitalize">{{ __('instagram') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://github.com/ahmedelsewailky" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/github.png') }}"
                                            alt="github">
                                        <span class="mt-1 text-capitalize">{{ __('github') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="app-item">
                                    <a href="https://www.linkedin.com/in/ahmed-elsewailky-a83882144/" target="_blank">
                                        <img src="{{ asset('dashboard/images/icons/linkedin.png') }}"
                                            alt="linkedin">
                                        <span class="mt-1 text-capitalize">{{ __('linkedin') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- ./Quick Links-->

                <!-- Notifications -->
                <li class="nav-item dropdown">
                        <a class="nav-link nav-link-icon" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-bell"></i>
                            {{-- <span class="count-label">3</span> --}}
                            <i class='bx bxs-circle bx-flashing bx-flip-horizontal icon-puls text-success'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mega-menu notification-menu">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('Notifications') }}</h6>
                                <a href="" class="small text-primary">{{ __('Mark all as read') }}</a>
                            </div>
                            <div style="height: 293px">
                                <div class="d-flex unread">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-5.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-2.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-3.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex unread">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-4.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('dashboard/images/avatars/user-6.png') }}" width="48"
                                            height="48" class="rounded-circle" alt="User profile image">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6>{{ fake()->name }}</h6>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <!-- ./Notifications -->
            </ul>
        </div>
    </nav>
</div>
