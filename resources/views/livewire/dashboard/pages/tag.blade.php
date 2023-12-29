<?php

use App\Models\Tag;
use Livewire\Volt\Component;
use Livewire\Attributes\{Computed, On};

new class extends Component {
    public $name = [];
    public $tag;

    #[On('tag-updated'), Computed]
    public function tags()
    {
        return Tag::orderByDesc('id')->get();
    }

    public function save()
    {
        sleep(1);
        Tag::create(
            $this->validate([
                'name.en' => ['required', 'string', 'max:50', 'unique:tags,name->en'],
                'name.ar' => ['required', 'string', 'max:50', 'unique:tags,name->ar'],
            ]),
        );
        $this->resetInputFields();
        $this->dispatch('tag-updated');
    }

    public function select(Tag $tag)
    {
        $this->tag = $tag;
        $this->name['en'] = $tag->getTranslation('name', 'en');
        $this->name['ar'] = $tag->getTranslation('name', 'ar');
    }

    public function update()
    {
        sleep(1);
        $this->tag->update(
            $this->validate([
                'name.en' => ['required', 'string', 'max:50', 'unique:tags,name->en,' . $this->tag->id],
                'name.ar' => ['required', 'string', 'max:50', 'unique:tags,name->ar,' . $this->tag->id],
            ]),
        );
        $this->dispatch('tag-updated');
    }

    public function delete()
    {
        sleep(1);
        $this->tag->delete();
        $this->resetInputFields();
        $this->dispatch('close-modal');
    }

    public function resetInputFields()
    {
        $this->reset('name.en', 'name.ar');
        $this->resetValidation();
    }
};

?>

<div>

    <x-slot name="title">
        {{ __('Tags') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Tags Management') }}</li>
    </x-slot>

    <div class="container">
        <div class="mb-3 d-block text-end">
            <button type="button" data-bs-toggle="modal" class="btn btn-outline-dark" data-bs-target="#createModal"><i
                    class="bx bx-plus me-1"></i>{{ __('Add New') }}</button>
        </div>

        {{-- Tag Table --}}
        <div class="table-responsive">
            <div class="card">
                <div class="p-0 card-body">
                    <table class="table mb-0 table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Tag Name') }}</th>
                                <th>{{ __('No. Of Posts') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->tags as $tag)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="text-capitalize">{{ $tag->getTranslation('name', auth()->user()->locale) }}</td>
                                    <td>{{ number_format(7452) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#updateModal"
                                            wire:click.prevent='select({{ $tag }})'><i class="bx bx-edit"></i></button>

                                        <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal"
                                            wire:click.prevent='select({{ $tag }})'><i class="bx bx-trash"></i></button>
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
                                <th>{{ __('Tag Name') }}</th>
                                <th>{{ __('No. Of Posts') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create tag Modal -->
    <div wire:ignore.self class="modal fade" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h6 class="modal-title fs-5">{{ __('Insert New tag') }}</h6>
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
                                    {{ __('The new tag name must be unique, not already existing.') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="name_en" value="{{ __('tag Name') }}" />
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <x-text-input id="name_en" wire:model='name.en'
                                        class="{{ $errors->get('name.en') ? 'is-invalid' : '' }}"
                                        placeholder="Fashion" />
                                    @error('name.en')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-text-input id="name_ar" wire:model='name.ar'
                                        class="{{ $errors->get('name.ar') ? 'is-invalid' : '' }}"
                                        placeholder="موضة وأزياء" />
                                    @error('name.ar')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" wire:ignore.self>
                        <x-action-message on="tag-updated" />

                        <button type="button" class="btn btn-secondary" wire:click='resetInputFields'
                            data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-dark">
                            {{ __('Save') }}
                            <span class="ms-1" wire:loading wire:target='save'>
                                <i class='bx bx-loader-alt bx-spin '></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update tag Modal -->
    <div wire:ignore.self class="modal fade" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="update">
                    <div class="modal-header">
                        <h6 class="modal-title fs-5">{{ __('Update Existing tag') }}</h6>
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
                                    {{ __('The new tag name must be unique, not already existing.') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="name_en" value="{{ __('tag Name') }}" />
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <x-text-input id="name_en" wire:model='name.en'
                                        class="{{ $errors->get('name.en') ? 'is-invalid' : '' }}"
                                        placeholder="Fashion" />
                                    @error('name.en')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-text-input id="name_ar" wire:model='name.ar'
                                        class="{{ $errors->get('name.ar') ? 'is-invalid' : '' }}"
                                        placeholder="موضة وأزياء" />
                                    @error('name.ar')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" wire:ignore.self>
                        <x-action-message on="tag-updated" />

                        <button type="button" class="btn btn-secondary" wire:click='resetInputFields'
                            data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-dark">
                            {{ __('Save Changes') }}
                            <span class="ms-1" wire:loading wire:target='update'>
                                <i class='bx bx-loader-alt bx-spin '></i>
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
                        <button type="button" class="btn btn-secondary" wire:click='resetInputFields'
                            data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Close') }}
                        </button>

                        <button type="submit" class="btn btn-danger">
                            {{ __('Yes I\'m Sure') }}
                            <span class="ms-1" wire:loading wire:target='update'>
                                <i class='bx bx-loader-alt bx-spin '></i>
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
        document.addEventListener('close-modal', () => {
            $(".modal").modal("hide");
        });
    </script>
@endpush
