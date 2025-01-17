@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-black dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
