<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{-- End Styles --}}
        {{-- scripts --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdn.tailwindcss.com/?plugins=forms"></script>
        {{-- end scripts --}}
    </head>
<body class="antialiased bg-gray-100">
    <div class="relative bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
          <div class="flex justify-between items-center border-b-2 border-gray-100 py-4 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
              <a href="/">
                <span class="sr-only">Workflow</span>
                <img class="h-10 w-auto sm:h-12" src={{ asset('img/Country-Synergy-Logo.png') }} alt="CS-logo">
              </a>
            </div>
            @if(Auth::guest())
            <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
                <a href="/login" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Sign in </a>
            </div>
            @else
            <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
              <form action="/sign-out" method="POST">
                @csrf
                <button type="submit" class="logout inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign Out
                </button>
              </form>
            </div>
            @endif
          </div>
        </div>
    </div>
    @yield('content')
</body>

{{-- scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
{{-- end scripts --}}
</html>
