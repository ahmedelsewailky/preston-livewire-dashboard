<?php

use App\Models\User;
use Laravolt\Avatar\Facade as Avatar;
use Livewire\Volt\Component;
use Livewire\Attributes\{Rule, Computed};

new class extends Component {
    #[Rule('required|string|max:255')]
    public string $name;
    #[Rule('required|string|alpha_dash|max:255|unique:users')]
    public string $username;
    #[Rule('required|email|max:255|unique:users')]
    public string $email;
    #[Rule('nullable|sometimes|string')]
    public string $phone;
    #[Rule('required|string|min:6')]
    public string $password;
    #[Rule('required|string|min:6|same:password')]
    public string $password_confirmation;
    #[Rule('required|exists:roles,name')]
    public string $role;
    public string $image;

    public function save()
    {
        sleep(1);
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'image' => 'users/' . $this->username. '.png',
        ]);
        Avatar::create($this->username)->save('storage/users/' . $this->username. '.png');
        $user->assignRole($this->role);
        $this->redirect(route('users.index'));
    }
};

?>

<div>
    <x-slot name="title">
        {{ __('Users') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" wire:navigate>{{ __('Users') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Add New User') }}</li>
    </x-slot>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="pb-3 mb-3 border-bottom">{{ __('Personal Information') }}</h5>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <form>
                            <!-- Role -->
                            <div class="mb-3">
                                <x-input-label for="role" value="{{ __('Role') }}" />
                                <select wire:model="role" id="role" class="form-select w-50 @error('role') is-invalid @enderror">
                                    <option value="" hidden>{{ __('--Select--') }}</option>
                                    @foreach (\Spatie\Permission\Models\Role::get() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fullname -->
                            <div class="mb-3">
                                <x-input-label for="name" value="{{ __('Fullname') }}" />
                                <x-text-input id="name" wire:model="name" type="text"
                                    class="{{ $errors->get('name') ? 'is-invalid' : false }}"
                                    placeholder="John Doe" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <x-input-label for="username" value="{{ __('Username') }}" />
                                <x-text-input id="username" wire:model="username" type="text"
                                    class="{{ $errors->get('username') ? 'is-invalid' : false }}"
                                    placeholder="johndoe" />
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <x-input-label for="email" value="{{ __('Email') }}" />
                                <x-text-input id="email" wire:model="email" type="email"
                                    class="{{ $errors->get('email') ? 'is-invalid' : false }}"
                                    placeholder="example@email.com" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <x-input-label for="phone" value="{{ __('Phone Number') }}" />
                                <x-text-input id="phone" wire:model="phone" type="text"
                                    class="{{ $errors->get('phone') ? 'is-invalid' : false }}"
                                    placeholder="+20123456789" />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" value="{{ __('Password') }}" />
                                <x-text-input id="password" wire:model="password" type="password" class="{{ $errors->get('password') ? 'is-invalid' : false }}" placeholder="********" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-3">
                                <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-text-input id="password_confirmation" wire:model="password_confirmation" type="password" class="{{ $errors->get('password_confirmation') ? 'is-invalid' : false }}" placeholder="********" />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <buttun type="submit" wire:click='save' class="btn btn-dark">
                                    {{ __('Save') }}

                                    <span class="ms-1" wire:loading wire:target='save'>
                                        <i class='bx bx-loader-alt bx-spin'></i>
                                    </span>
                                </buttun>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('dashboard/svg/add_user.svg') }}" class="w-75" title="Add new user" alt="add user svg image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
