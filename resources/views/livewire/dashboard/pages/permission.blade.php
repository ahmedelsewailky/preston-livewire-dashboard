<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Computed, On};
use Spatie\Permission\Models\Permission;

new class extends Component {
    public string $name;

    public $permission;

    #[Computed]
    public function permissions()
    {
        return Permission::all();
    }

    public function save()
    {
        sleep(1);

        Permission::create(
            $this->validate([
                'name' => ['required', 'string', 'max:255', 'unique:' . Permission::class],
            ]),
        );

        $this->dispatch('permission-updated');

        $this->reset('name');
    }

    public function select(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;
    }

    public function update()
    {
        sleep(1);
        $this->permission->update(
            $this->validate([
                'name' => ['required', 'string', 'max:50', 'unique:permissions,name,' . $this->permission->id],
            ])
        );
        $this->dispatch('permission-updated');
    }

    public function delete()
    {
        sleep(1);
        $this->permission->delete();
        $this->resetInputFields();
        $this->dispatch('close-modal');
    }

    public function resetInputFields()
    {
        $this->reset('name');
        $this->resetValidation();
    }
};

?>

<div>
    <x-slot name="title">
        {{ __('Permissions') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Permission') }}</li>
    </x-slot>

    <!-- Permission Table  -->
    <div class="container">
        <div class="mb-3 d-block text-end">
            <button type="button" data-bs-toggle="modal" class="btn btn-outline-dark" data-bs-target="#createModal"><i
                    class="bx bx-plus me-1"></i>{{ __('Add New') }}</button>
        </div>

        <div class="table-responsive">
            <div class="card w-50 mx-auto">
                <div class="card-body">
                    <table class="table mb-0 table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Permission') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->permissions as $permission)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <button type="button" data-bs-toggle="modal" class="btn btn-sm btn-success"
                                            data-bs-target="#updateModal"
                                            wire:click.prevent='select({{ $permission }})'>{{ __('Edit') }}</button>

                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal" class="btn btn-sm btn-danger"
                                            wire:click.prevent='select({{ $permission }})'>{{ __('Delete') }}</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center" x-text="@js(__('No data available'))"></td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Permission') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <div wire:ignore.self class="modal fade" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h6 class="modal-title fs-5">{{ __('Assign New Permission') }}</h6>
                        <button type="button" wire:click='resetInputFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="bg-transparent alert alert-warning border-warning small" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-">
                                    <i class="bx bx-sm bxs-error me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Note!') }}</strong>
                                    {{ __('The new permission name must be unique, not already existing.') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="name" value="{{ __('Permission Name') }}" />
                            <x-text-input id="name" wire:model='name'
                                class="{{ $errors->get('name') ? 'is-invalid' : '' }}" placeholder="users-list" />
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer" wire:ignore.self>
                        <x-action-message on="permission-updated" />

                        <button type="button" class="btn btn-secondary " wire:click='resetInputFields' data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-dark">
                            {{ __('Save') }}
                            <span class="ms-2" wire:loading wire:target='save'>
                                <i class='bx  bx-loader-alt bx-spin '></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Permission Modal -->
    <div wire:ignore.self class="modal fade" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="update">
                    <div class="modal-header">
                        <h6 class="modal-title fs-5">{{ __('Update Existing Permission') }}</h6>
                        <button type="button" wire:click='resetInputFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="bg-transparent alert alert-warning border-warning small" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-">
                                    <i class="bx bx-sm bxs-error me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Note!') }}</strong>
                                    {{ __('The new permission name must be unique, not already existing.') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="name" value="{{ __('Permission Name') }}" />
                            <x-text-input id="name" wire:model='name'
                                class="{{ $errors->get('name') ? 'is-invalid' : '' }}" placeholder="users-list" />
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer" wire:ignore.self>
                        <x-action-message on="permission-updated" />

                        <button type="button" class="btn btn-secondary" wire:click='resetInputFields' data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-primary ">
                            {{ __('Save Changes') }}
                            <span class="ms-2" wire:loading wire:target='update'>
                                <i class='bx  bx-loader-alt bx-spin '></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div wire:ignore.self class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="delete">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('Attention') }}</h6>
                        <button type="button" wire:click='resetInputFields' class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <i class="bx bx-lg bx-error text-danger"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="small">
                                    {{ __('You are going to delete the record, Are you sure?') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " wire:click='resetInputFields' data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-danger ">
                            {{ __('Yes I\'m Sure') }}
                            <span class="ms-2" wire:loading wire:target='update'>
                                <i class='bx  bx-loader-alt bx-spin '></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            document.addEventListener('close-modal', () => {
                $(".modal").modal("hide");
            });
        });
    </script>
@endpush
