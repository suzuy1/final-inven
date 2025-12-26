@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-white rounded-lg bg-blue-700 group transition duration-75'
            : 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group transition duration-75';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>