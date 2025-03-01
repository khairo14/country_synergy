<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_NAME')}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- End Styles --}}
    {{-- scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.9.5/dist/cdn.min.js"></script>
    {{-- end scripts --}}
</head>
<body class="min-h-full overflow-auto antialiased bg-gray-300">
    <div x-data={open:false}>
        {{-- Relative sidebar for mobile --}}
            @include('layouts.sidebarMobile')
        {{--Static sidebar for desktop--}}
            @include('layouts.sidebar')

        <div class="flex flex-col md:pl-64">
            {{-- Top layout --}}
            @include('layouts.topbar')
            {{-- Main Layout --}}
            <main class="flex-1 overflow-x-hidden">
                <div class="p-2">
                    @yield('content')
                </div>
            </main>
        </div>
        {{-- footer --}}
    </div>
</body>

{{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- end scripts --}}
</html>
