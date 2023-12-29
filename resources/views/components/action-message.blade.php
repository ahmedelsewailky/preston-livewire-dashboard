@props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;" {{ $attributes }}>
    <div class="me-3 d-flex">
        <i class='bx bxs-check-circle text-success me-2' ></i>
        {{ $slot->isEmpty() ? __('Saved Success.') : $slot }}
    </div>
</div>
