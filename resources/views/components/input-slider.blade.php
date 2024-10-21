@props([
    'label' => '',
    'id' => 'slider',
    'value' => 1,
    'min' => 1,
    'max' => 10,
    'step' => 1,
    'error' => null,
])

<div 
    x-data="{ value: {{ old($id, $value) }} }" 
    class="relative my-2 p-4 text-black dark:text-white dark:bg-slate-900 dark:border-gray-700 dark:focus:ring-gray-600"
>
    <label 
        for="{{ $id }}" 
        class="block text-md font-medium mb-2 break-words"
    >
        {{ $label }}: 
        <output x-text="value"></output>
    </label>

    <input 
        type="range" 
        id="{{ $id }}" 
        min="{{ $min }}" 
        max="{{ $max }}" 
        step="{{ $step }}" 
        x-model="value" 
        {{ $attributes->merge([
            'class' => "w-full h-2 bg-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
        ]) }}
    >

    @if ($error)
        <p class="text-red-600 text-sm mt-1">{{ $error }}</p>
    @endif
</div>
