@props([
    'label' => '',
    'id' => 'none',
    'value' => '',
    'error' => null,
])

<div class="relative my-2">
    <input 
        {{ $attributes->merge([
            'class' => "peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2",
            'id' => "hs-floating-input-$id",
        ]) }}
        type="text" 
        name="{{ $id }}"
        placeholder="{{ $label }}"
        value="{{ old($id, $value) }}"
    >
    <label 
        {{ $attributes->merge([
            'class' => "absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500",
            'for' => "hs-floating-input-$id",
        ]) }}
    >
        {{ $label }}
    </label>
    @if ($error)
        <p class="text-red-600 text-sm ms-2">{{ $error }}</p>
    @endif
</div>
