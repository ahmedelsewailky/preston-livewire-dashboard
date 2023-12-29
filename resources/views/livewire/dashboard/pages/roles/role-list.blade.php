<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\{Role, Permission};

new class extends Component {

    #[Computed]
    public function roles()
    {
        return Role::with('permissions')->get();
    }

    #[Computed]
    public function permissions()
    {
        return Permission::all();
    }

    public function delete(Role $role)
    {
        $role->delete();
    }
};

?>

<div>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Roles Management') }}</li>
    </x-slot>

    <div class="container">
        <div class="mb-3 d-block text-end">
            <a href="{{ route('role.create') }}" class="btn btn-outline-dark">
                <i class="bx bx-plus me-1"></i>{{ __('Add New') }}
            </a>
        </div>

        @if ($this->roles->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped-columns">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach ($this->roles as $role)
                                        <th class="w-25">
                                            <div class="items-center d-flex">
                                                {{ $role->name }}
                                                <div class="dropdown ms-auto">
                                                    <a href="" data-bs-toggle="dropdown"><i class="bx bx-menu"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{ route('role.update', $role->id) }}" class="dropdown-item" wire:navigate>{{ __('Edit') }}</a>
                                                        <a href="" wire:confirm="{{ __('Are you sure?') }}" wire:click.prevent="delete({{ $role }})" class="dropdown-item">{{ __('Delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        @foreach ($this->roles as $role)
                                            <td>
                                                <i class="bx bx-{{ $role->hasPermissionTo($permission->name) ? 'check-double text-primary' : 'x text-danger' }}"></i>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center">{{ __('There are no roles yet.') }}</p>
        @endif
    </div>
</div>
