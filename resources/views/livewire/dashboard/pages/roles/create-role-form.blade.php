<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\{Role, Permission};

new class extends Component {
    public string $name;

    public $permissions = [];

    #[Computed]
    public function getPermissions()
    {
        return Permission::all();
    }

    public function save()
    {
        sleep(1);

        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions.*' => ['required', 'exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $this->name]);

        $role->syncPermissions($this->permissions);

        return $this->redirect(route('role.index'));
    }
};

?>

<div>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('role.index') }}" wire:navigate>{{ __('Roles') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create New Role') }}</li>
    </x-slot>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <x-input-label for="name" value="{{ __('Role Name') }}" />
                        <x-text-input id="name" wire:model="name" type="text"
                            class="{{ $errors->get('name') ? 'is-invalid' : false }} w-50"
                            placeholder="ex: users-list" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <x-input-label for="permissions" value="{{ __('Permissions') }}" />
                        <p class="mb-3 text-muted small">{{ __('Select the permissions for this new job role') }}</p>
                        <div class="row">
                            @forelse ($this->getPermissions as $permission)
                                <div class="mb-3 col-6 col-md-3">
                                    <input type="checkbox" wire:model="permissions" class="form-check-input me-2"
                                        value="{{ $permission->name }}" id="permission-{{ $permission->name }}">
                                    <label for="permission-{{ $permission->name }}"
                                        class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @empty
                                <p class="text-center">{{ __('No permissions avaialble') }}</p>
                            @endforelse
                        </div>
                        @error('permissions.*')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-dark">
                            {{ __('Save') }}
                            <span class="ms-1" wire:loading wire:target='save'>
                                <i class='bx bx-loader-alt bx-spin'></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
