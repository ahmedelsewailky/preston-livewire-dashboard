<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\{Role, Permission};

new class extends Component {
    #[Computed]
    public function users()
    {
        return User::whereNot('id', auth()->user()->id)->get();
    }

    public function delete(User $user)
    {
        $user->delete();
    }
};

?>

<div>
    <x-slot name="title">
        {{ __('Users') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Users Management') }}</li>
    </x-slot>

    <div class="container">
        <div class="mb-3 d-block text-end">
            <a href="{{ route('users.create') }}" class="btn btn-outline-dark">
                <i class="bx bx-plus me-1"></i>{{ __('Add New') }}
            </a>
        </div>

        <div class="row">
            @forelse ($this->users as $user)
                <div class="col-12 col-md-6">
                    <div class="mb-3 card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('storage\\') . $user->image }}" width="48" alt="{{ $user->name }}">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold">{{ $user->name }}</h6>

                                    <div class="ps-2">
                                        <div class="my-2 small d-flex align-items-center">
                                            <i class="bx bx-envelope me-2 text-green"></i>
                                            <p>{{ $user->email }}</p>
                                        </div>

                                        <div class="my-2 small d-flex align-items-center">
                                            <i class="bx bx-phone-call me-2 text-green"></i>
                                            <p>{{ $user->phone ?? 'NULL' }}</p>
                                        </div>

                                        <div class="my-2 small d-flex align-items-center">
                                            <i class="bx bx-shield-plus me-2 text-green"></i>
                                            <p class="text-capitalize">{{ $user->getRoleNames()[0] }}</p>
                                        </div>

                                        <div class="my-2 small d-flex align-items-center">
                                            <i class="bx bx-calendar me-2 text-green"></i>
                                            <p>{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex">
                                        <a href="{{ route('users.update', $user->id) }}" class="btn btn-sm btn-outline-success me-1"><i class="bx bx-edit"></i> {{ __('Edit') }}</a>
                                        <a href="" wire:confirm="{{ __('Are you sure?') }}" wire:click.prevent='delete({{ $user }})' class="btn btn-sm btn-outline-danger me-1"><i class="bx bx-trash"></i> {{ __('Delete') }}</a>
                                        <a href="" class="btn btn-sm btn-outline-primary"><i class="bx bx-paper-plane"></i> {{ __('Send Message') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">{{ __('There are no users yet.') }}</p>
            @endforelse
        </div>
    </div>
</div>
