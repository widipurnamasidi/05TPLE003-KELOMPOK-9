@props(['href', 'current' => false, 'ariaCurrent' => false])

@php
    // $classes = $current ? 'bg-grey-900 text-white' : 'text-grey-300 hover:bg-grey-700 hover:text-white';
    if ($current) {
        $classes = 'bg-gray-900 text-white';
    } else {
        $classes = 'text-gray-300 hover:bg-white/5 hover:text-white';
    }
@endphp

<a href="{{ $href }}"
  {{ $attributes->merge(['class' => 'rounded-md px-3 py-2 text-sm font-medium ' . $classes, 'aria-current' => $ariaCurrent]) }}>{{ $slot }}</a>
