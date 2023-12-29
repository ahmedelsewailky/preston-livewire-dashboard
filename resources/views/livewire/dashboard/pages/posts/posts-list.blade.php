<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $limit = 50;
    public $views = '';
    public $author = '';
    public $category = '';
    public $status = '';

    #[Computed]
    public function posts()
    {
        $posts = new Post();
        $posts = $this->search ? $posts->where('title', 'like', '%' . $this->search . '%') : $posts;
        $posts = $this->author ? $posts->whereUserId($this->author) : $posts;
        $posts = $this->category ? $posts->whereCategoryId($this->category) : $posts;
        $posts = $this->status ? $posts->where('status', $this->status) : $posts;
        $posts = $this->views ? $posts->orderBy('views', $this->views) : $posts;
        return $posts->orderByDesc('id')->paginate($this->limit);
    }

    public function delete(Post $post)
    {
        Storage::delete('public/' . $post->image);
        $post->delete();
    }
};

?>

<div>
    <x-slot name="title">
        {{ __('Posts') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Posts') }}</li>
    </x-slot>

    <div class="container">
        <div class="mb-3 d-block text-end">
            <a href="{{ route('posts.create') }}" class="btn btn-outline-dark">
                <i class="bx bx-plus me-1"></i>{{ __('Create New Post') }}
            </a>
        </div>

        <div class="container">
            <div class="filter-box row">
                <!-- Filter By Author -->
                <div class="mb-3 col-12 col-md-3">
                    <label for="author" class="form-label">{{ __('By Author') }}</label>
                    <select wire:model.live="author" id="author" class="form-select">
                        <option value="">{{ __('--Select--') }}</option>
                        @foreach (\App\Models\User::get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter By Status -->
                <div class="mb-3 col-12 col-md-3">
                    <label for="status" class="form-label">{{ __('By Status') }}</label>
                    <select wire:model.live="status" id="status" class="form-select">
                        <option value="">{{ __('--Select--') }}</option>
                        <option value="published">{{ __('Published') }}</option>
                        <option value="draft">{{ __('Draft') }}</option>
                    </select>
                </div>

                <!-- Filter By Views -->
                <div class="mb-3 col-12 col-md-3">
                    <label for="views" class="form-label">{{ __('By Views') }}</label>
                    <select wire:model.live="views" id="views" class="form-select">
                        <option value="">{{ __('--Select--') }}</option>
                        <option value="desc">{{ __('Most Views') }}</option>
                        <option value="asc">{{ __('Least Views') }}</option>
                    </select>
                </div>

                <!-- Filter Limit -->
                <div class="mb-3 col-12 col-md-3">
                    <label for="limit" class="form-label">{{ __('Limit') }}</label>
                    <select wire:model.live="limit" id="limit" class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="150">150</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </div>

                <!-- Filter By Category -->
                <div class="mb-3 col-12 col-md-4">
                    <label for="category" class="form-label">{{ __('By Category') }}</label>
                    <select wire:model.live="category" id="category" class="form-select">
                        <option value="">{{ __('--Select--') }}</option>
                        @foreach (\App\Models\Category::get() as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}({{ $category->posts->count() }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div class="mb-3 col-12 col-md-4 offset-md-4">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <input type="search" id="search" wire:model.live="search" class="form-control"
                        placeholder="{{ __('Search') }}">
                </div>
            </div>
        </div>

        <div class="p-0 card">
            <div class="p-0 card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Views') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->posts as $post)
                                <tr>
                                    <td><small class="fw-semibold">#P{{ $post->id }}</small></td>
                                    <td>
                                        @if ($post->image)
                                            <img src="{{ asset('storage\\') . $post->image }}" width="80"
                                                height="65" alt="Post Image">
                                        @else
                                            <img src="{{ asset('dashboard\images\thumbnail.png') }}" width="80"
                                                height="65" alt="Post Image">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="">{{ str($post->title)->words(3) }}</a>
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td><i class="bx bx-bar-chart-alt-2 me-2"></i>{{ number_format($post->views) }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $post->status == 'draft' ? 'draft' : 'published' }}">
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                    <td class="text-center text-md-start">
                                        <div class="d-flex">
                                            <a href="{{ route('posts.update', $post->id) }}"
                                                class="mb-1 btn btn-sm btn-outline-success mb-md-0 me-1"><i class="bx bx-edit"></i></a>
                                            <a href="" wire:confirm='{{ __('Are you sure?') }}'
                                                wire:click.prevent='delete({{ $post }})'
                                                class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">{{ __('No data available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {!! $this->posts->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>
