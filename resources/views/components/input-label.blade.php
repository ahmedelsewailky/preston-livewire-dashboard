@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label mb-2']) }}>
    {{ $value ?? $slot }}
</label>
