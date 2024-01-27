
@props(['separator' => ' / '])

<ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
    @php
        $segments = explode('.', Route::currentRouteName());
        $url = '';
        $count = count($segments);

        for ($i = 0; $i < $count; $i++) {
            $url .= ($url ? '.' : '') . $segments[$i];
            $title = ucfirst($segments[$i]);
    @endphp

        <li class="inline-flex items-center">
            <a class="flex items-center text-sm text-gray-200 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                {{ $title }}
            </a>
            
            @if ($i < $count - 1)
                <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            @endif
        </li>

    @php
        }
    @endphp
</ol>
