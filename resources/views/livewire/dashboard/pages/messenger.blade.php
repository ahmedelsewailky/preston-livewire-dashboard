<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Messenger;
use Livewire\Volt\Component;
use Livewire\Attributes\{Computed, On};

new class extends Component {
    public $receiver;
    public $message;
    public $messages;
    public $searchUser;
    public $unReadableCount;

    public function mountData()
    {
        if (isset($this->receiver)) {
            $this->messages = Messenger::where('user_id', auth()->user()->id)
                ->where('receiver_id', $this->receiver->id)
                ->orWhere('user_id', $this->receiver->id)
                ->where('receiver_id', auth()->user()->id)
                ->get();
                $this->updatedAsRead();
        }
    }

    public function send()
    {
        Messenger::create([
            'user_id' => auth()->user()->id,
            'receiver_id' => $this->receiver->id,
            'message' => $this->message,
        ]);

        $this->getReceiver($this->receiver);

        $this->reset('message');
    }

    public function getReceiver(User $user)
    {
        $this->receiver = $user;

        $this->messages = Messenger::where('user_id', auth()->user()->id)
            ->where('receiver_id', $user->id)
            ->orWhere('user_id', $user->id)
            ->where('receiver_id', auth()->user()->id)
            ->get();
    }

    private function updatedAsRead()
    {
        $messages = Messenger::where('receiver_id', auth()->user()->id)->get();

        if ($messages) {
            foreach ($messages as $message) {
                $message->update(['read_at' => now()]);
            }
        }
    }

    #[Computed]
    public function users()
    {
        $users = User::whereNot('id', auth()->user()->id);
        $users = $this->searchUser ? $users->where('name', 'like', '%' . $this->searchUser . '%') : $users;
        return $users->get();
    }

    public function getUnReadMessagesCount($receiverId)
    {
        $this->unReadableCount = Messenger::where('receiver_id', $receiverId)->whereNull('read_at')->get()->count;
    }

};

?>

<div>
    <x-slot name="title">
        {{ __('Messenger') }}
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Messenger') }}</li>
    </x-slot>

        <div class="container">
            <div class="card">
                <div class="p-0 card-body">
                    <div class="chat-app">
                        <div class="row g-0">
                            <!-- ============================================ Contacts -->
                            <div class="col app-chat-list">
                                <form action="" class="chat-list-form d-none d-md-block">
                                    <input type="search" wire:model.live='searchUser' name="search" class="form-control"
                                        placeholder="{{ __('Search') }}">
                                    <i class="bx bx-search"></i>
                                </form>

                                <div class="chat-list-contacts" wire:poll='mountData'>
                                    @foreach ($this->users as $user)
                                        <div class="d-flex contact-item {{ $receiver && $receiver->id == $user->id ? 'active' : false }}"
                                            wire:click='getReceiver({{ $user }})'>
                                            <div class="flex-shrink-0 me-2 position-relative">
                                                <img src="{{ asset('storage\\') . $user->image }}" alt="User image">
                                                <span
                                                    class="activate-status {{ $user->last_seen >= now()->subMinutes(1) ? 'online' : false }}"></span>
                                            </div>
                                            <div class="flex-grow-1 d-none d-md-block">
                                                <div class="d-flex">
                                                    <h6>{{ $user->name }}</h6>
                                                    @php
                                                        $unReadableMessages = Messenger::where('user_id', $user->id)->whereNull('read_at')->get()->count()
                                                    @endphp
                                                    @if ($unReadableMessages > 1)
                                                        <span class="count-label ms-auto bg-success">{{ $unReadableMessages }}</span>
                                                    @endif
                                                </div>
                                                @if ($user->last_seen)
                                                    @if ($user->last_seen >= now()->subMinutes(1))
                                                        <small>{{ __('Online') }}</small>
                                                    @else
                                                        <small>{{ $user->last_seen->diffForHumans() }}</small>
                                                    @endif
                                                @else
                                                    <small>{{ __('Offline') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- ./Contacts -->


                            <div class="col chat-box position-relative">
                                @if ($receiver)
                                    <!-- ============================================ Chat Box Header -->
                                    <div class="chat-box-header">
                                        <div class="d-flex user-chat-head align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="{{ asset('storage\\') . $receiver->image }}" alt="User image">
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <div>
                                                    <h6>{{ $receiver->name }}</h6>
                                                    @if ($receiver->last_seen)
                                                        @if ($receiver->last_seen >= now()->subMinutes(1))
                                                            <small>{{ __('Online') }}</small>
                                                        @else
                                                            <small>{{ $receiver->last_seen->diffForHumans() }}</small>
                                                        @endif
                                                    @else
                                                        <small>{{ __('Offline') }}</small>
                                                    @endif
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:void(0)" class="mx-2"><i class="bx bx-phone"></i></a>
                                                    <a href="javascript:void(0)" class="mx-2"><i class="bx bx-video"></i></a>
                                                    <a href="javascript:void(0)" class="mx-2"><i class="bx bx-info-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ============================================ Chat Box History -->
                                    <div class="chat-box-history">
                                        <ul class="flex-column nav" wire:poll='mountData'>
                                            @foreach ($messages as $msg)
                                                @if ($msg->user_id == auth()->user()->id)
                                                    <li class="mb-3">
                                                        <p class="chat-message">{{ $msg->message }}</p>
                                                        <small class="d-flex align-items-center">
                                                            <i class='bx bx-check{{ $msg->read_at ? '-double text-primary' : false }} me-1'></i>
                                                            {{ $msg->created_at->format('g:i a') }}
                                                        </small>
                                                    </li>
                                                @else
                                                    <li class="mb-3 receiver d-flex ms-auto">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 text-end">
                                                                <p class="chat-message">{{ $msg->message }}</p>
                                                                <small>{{ $msg->created_at->format('g:i a') }}</small>
                                                            </div>
                                                            <div class="flex-shrink-0 ms-2">
                                                                <img src="{{ asset('storage\\') . $msg->receiver->image }}"
                                                                    alt="User image">
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="chat-box-form">
                                        <form wire:submit.prevent="send" class="d-flex">
                                            <input type="text" wire:model="message" id="message" class="form-control me-1"
                                                placeholder="{{ __('Enter text here...') }}">
                                            <button type="submit" class="btn btn-sm btn-dark">{{ __('Send') }}</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center empty-chat-history">
                                        <img src="{{ asset('dashboard/svg/chat.svg') }}" alt="">
                                    </div>
                                @endif
                            </div>
                            <!-- ./Chat -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
