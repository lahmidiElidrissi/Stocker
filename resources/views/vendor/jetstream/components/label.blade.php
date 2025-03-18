@props(['value'])

<div class="row" >
        <label {{ $attributes->merge(['class' => 'text-lg']) }}>
            {{ $value ?? $slot }}
        </label>
</div>
