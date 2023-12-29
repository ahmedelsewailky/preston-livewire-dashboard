<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\Attributes\{Rule, Computed};

new class extends Component {
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->role = $user->getRoleNames()->first();
        $this->fill($user->only('name', 'username', 'email', 'phone'));
    }

    public function update()
    {
        sleep(1);

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|alpha_dash|max:255|unique:users,username,' . $this->user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|sometimes|string',
            'password' => 'nullable|sometimes|string|min:6',
            'password_confirmation' => 'required_with:password|string|min:6|same:password',
        ]);

        if ($this->user->email !== $this->email) {
            $this->user->update(['email_verified_at' => null]);
        }

        $this->user->update([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password ? bcrypt($this->password) : $this->user->password,
        ]);

        $this->user->syncRoles($this->role);

        $this->redirect(route('users.index'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        if ($this->user->hasVerifiedEmail()) {
            $path = session('url.intended', RouteServiceProvider::HOME);

            $this->redirect($path);

            return;
        }

        $this->user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
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
                                <select wire:model="role" id="role"
                                    class="form-select text-capitalize w-50 @error('role') is-invalid @enderror">
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
                                    class="{{ $errors->get('name') ? 'is-invalid' : false }}" placeholder="John Doe" />
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
                                <x-text-input id="email" wire:model="email" name="email" type="email"
                                    class="{{ $errors->get('email') ? 'is-invalid' : false }}"
                                    placeholder="example@email.com" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

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
                                <x-text-input id="password" wire:model="password" type="password"
                                    class="{{ $errors->get('password') ? 'is-invalid' : false }}"
                                    placeholder="********" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-3">
                                <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-text-input id="password_confirmation" wire:model="password_confirmation"
                                    type="password"
                                    class="{{ $errors->get('password_confirmation') ? 'is-invalid' : false }}"
                                    placeholder="********" />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <buttun type="submit" wire:click='update' class="btn btn-dark">
                                    {{ __('Save Changes') }}

                                    <span class="ms-1" wire:loading wire:target='update'>
                                        <i class='bx bx-loader-alt bx-spin'></i>
                                    </span>
                                </buttun>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('dashboard/svg/add_user.svg') }}" class="w-75" title="Add new user"
                            alt="add user svg image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
