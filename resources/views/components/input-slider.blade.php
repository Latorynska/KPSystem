@props([
    'label' => '',
    'id' => 'slider',
    'value' => 1,
    'min' => 1,
    'max' => 10,
    'step' => 1,
    'error' => null,
])

<div x-data="{ value: {{ old($id, $value) }} }" class="relative my-2 dark:text-white text-black dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 p-4">
    <label 
        for="{{ $id }}" 
        class="h-full text-md truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500"
    >
        {{ $label }} : 
        <output class="" x-text="value"></output>
    </label>
    <input 
        type="range" 
        id="{{ $id }}" 
        min="{{ $min }}" 
        max="{{ $max }}" 
        step="{{ $step }}" 
        x-model="value" 
        {{ $attributes->merge([
            'class' => "peer p-2 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2"
        ]) }}
    >
    @if ($error)
        <p class="text-red-600 text-sm ms-2">{{ $error }}</p>
    @endif
</div>
