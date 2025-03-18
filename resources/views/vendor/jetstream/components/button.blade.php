<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-login btn']) }}>
    {{ $slot }}
</button>
