@props([
    'type' => 'default',
    'tag' => '',
    'href' => '#',
])
@if($tag == 'a')
    <a 
        {{ $attributes->merge([
            'class' => "flex items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700",
        ])}}
        href="{{$href}}"
    >
        {{$slot}}
    </a>
@else
    <button
        {{ $attributes->merge([
            'class' => "flex w-full items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700",
        ])}}
        type="{{$type}}"
    >
        {{$slot}}
    </button>
@endif