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
        {{-- end scripts --}}
    </head>
    <body class="antialiased bg-gray-100">
        <div class="relative bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
              <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                  <a href="/">
                    <span class="sr-only">Workflow</span>
                    <img class="h-10 w-auto sm:h-12" src={{ asset('img/Country-Synergy-Logo.png') }} alt="CS-logo">
                  </a>
                </div>

                <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
                  <a href="/login" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Sign in </a>
                </div>
              </div>
            </div>
        </div>
        {{-- Scan Page --}}
        <div class="mx-auto h-full flex flex-col items-center justify-center py-6 px-4 sm:px-6 lg:px-8">

            <div class="flex row-start-1 items-center space-y-8 justify-center">
              <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Warehouse System</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
              </div>
            </div>

            <div class="flex row-start-2 space-y-8 items-center justify-center">
                <button type="button" class="scan inline-flex items-center border border-gray-300 rounded-md px-12 py-12 shadow-sm text-2xl font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Scan Items
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </body>

    {{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    {{-- end scripts --}}
</html>

</div>
