<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- sweetalert -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-full bg-gray-100 dark:bg-gray-900">
            @include('layouts.sidenav')
            <!-- Main Content -->
            <div class="flex-1 min-h-screen overflow-x-hidden"> <!-- added overflow-x-hidden to prevent horizontal overflow -->
                @include('layouts.navigation')
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                <!-- Page Content -->
                <main>
                    <div class="flex pt-4">
                        <div class="pt-4 pb-0 px-8 hidden sm:inline">
                            <button 
                                onclick="history.go(-1)" 
                                class="inline-flex items-start px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-md hover:bg-green-900 focus:outline-none focus:ring focus:border-green-800 dark:bg-green-700 dark:hover:bg-green-900 dark:focus:outline-none dark:focus:ring dark:focus:border-green-800"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                                <span class="ml-2">Back</span>
                            </button>
                        </div>
                        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> <!-- removed unnecessary h-full class -->
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <x-breadcrumb separator=" / " />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            })
            @if(Session::has('message'))
                var type = "{{Session::get('alert-type')}}";
                switch (type) {
                    case 'info':
                        Toast.fire({
                        icon: 'info',
                        title: "{{ Session::get('message') }}"
                        })
                    break;
                    case 'success':
                        Toast.fire({
                        icon: 'success',
                        title: "{{ Session::get('message') }}"
                        })
                    break;
                    case 'warning':
                        Toast.fire({
                        icon: 'warning',
                        title: "{{ Session::get('message') }}"
                        })
                    break;
                        case 'error':
                        Toast.fire({
                        icon: 'error',
                        title: "{{ Session::get('message') }}"
                        })
                    break;
                    case 'dialog_error':
                        Swal.fire({
                        icon: 'error',
                        title: "Ooops",
                        text: "{{ Session::get('message') }}",
                        timer: 3000
                        })
                    break;
                }
            @endif
            @if ($errors->any())
                @php $list = null; @endphp
                @foreach($errors->all() as $error)
                @php $list .= '<li>'.$error.'</li>'; @endphp
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: "Ooops",
                    html: "<ul>{!! $list !!}</ul>",
                })
            @endif
        </script>
    </body>
    
</html>
