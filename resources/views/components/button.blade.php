@props([
    'type' => 'default',
    'tag' => '',
    'href' => '#',
    'color' => 'gray',
])

@php
    $colors = [
        'default' => 'bg-gray-100 text-gray-500 hover:bg-gray-500 focus:ring-gray-500 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600',
        'primary' => 'bg-blue-100 text-blue-500 hover:bg-blue-500 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600',
        'success' => 'bg-green-100 text-green-500 hover:bg-green-500 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-green-600',
        'warning' => 'bg-yellow-100 text-yellow-500 hover:bg-yellow-500 focus:ring-yellow-500 dark:bg-yellow-700 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600',
        'danger' => 'bg-red-100 text-red-500 hover:bg-red-500 focus:ring-red-500 dark:bg-red-700 dark:hover:bg-red-600 dark:focus:ring-red-600',
    ];
    $colorClass = isset($colors[$color]) ? $colors[$color] : 'bg-gray-100 text-gray-500 hover:bg-gray-500 focus:ring-gray-500 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600';
@endphp

@if($tag == 'a')
    <a  {{ 
            $attributes->merge([
                'class' => "py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold hover:text-white focus:outline-none focus:ring-2 ring-offset-white focus:ring-offset-2 transition-all text-sm dark:text-white dark:focus:ring-offset-gray-800 $colorClass",
            ])
        }}
        href="{{$href}}"
    >
        {{ $slot }}
    </a>
@else
    <button {{ 
            $attributes->merge([
                'class' => "py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold hover:text-white focus:outline-none focus:ring-2 ring-offset-white focus:ring-offset-2 transition-all text-sm dark:text-white dark:focus:ring-offset-gray-800 $colorClass",
            ])
        }}
    >
        {{ $slot }}
    </button>
@endif
