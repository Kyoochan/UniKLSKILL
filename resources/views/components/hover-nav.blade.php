@props(['href'])

@php
    $isActive = request()->fullUrlIs(url($href)) || request()->routeIs($href);
@endphp

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            ($isActive ? 'bg-blue-900 text-white' : 'text-gray-700 hover:bg-gray-200 hover:text-blue-600') .
            ' p-3 rounded-md transition duration-400 ease-in-out',
    ]) }}
    aria-current="{{ $isActive ? 'page' : 'false' }}">
    {{ $slot }}
</a>
