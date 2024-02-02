@props([
    'type' => 'default',
    'tag' => '',
    'href' => '#',
    'color' => 'gray',
])

@php
    $colors = [
        'default' => 'gray',
        'primary' => 'blue',
        'success' => 'green',
        'warning' => 'yellow',
        'danger' => 'red',
    ];
    $colorClass = isset($colors[$color]) ? $colors[$color] : 'gray';
@endphp

@if($tag == 'a')
    <a  {{ 
            $attributes->merge([
                'class' => "py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md bg-$colorClass-100 border border-transparent font-semibold text-$colorClass-500 hover:text-white hover:bg-$colorClass-500 focus:outline-none focus:ring-2 ring-offset-white focus:ring-$colorClass-500 focus:ring-offset-2 transition-all text-sm dark:bg-$colorClass-700 dark:hover:bg-$colorClass-600 dark:focus:ring-$colorClass-600 dark:text-white dark:focus:ring-offset-gray-800",
            ])
        }}
        href="{{$href}}"
    >
        {{ $slot }}
    </a>
@else
    <button {{ 
            $attributes->merge([
                'class' => "py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md bg-$colorClass-100 border border-transparent font-semibold text-$colorClass-500 hover:text-white hover:bg-$colorClass-500 focus:outline-none focus:ring-2 ring-offset-white focus:ring-$colorClass-500 focus:ring-offset-2 transition-all text-sm dark:bg-$colorClass-700 dark:hover:bg-$colorClass-600 dark:focus:ring-$colorClass-600 dark:text-white dark:focus:ring-offset-gray-800",
            ])
        }}
    >
        {{ $slot }}
    </button>
@endif
