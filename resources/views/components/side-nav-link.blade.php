@props(['active'])

@php
$classes = ($active)
            ? "flex items-center gap-x-3.5 py-3 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-900 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
            : "flex items-center gap-x-3.5 py-3 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-900 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{$slot}}
    </a>
</li>