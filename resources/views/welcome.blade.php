<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <body class="antialiased">
        <div class="min-h-full flex items-center justify-center pt-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
              <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Warehouse System</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
              </div>
            </div>
          </div>

          <div class="min-h-full flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
            {{-- <div class="max-w-md w-full space-y-8 bg-gray-300 items-center justify-center"> --}}
                <button type="button" class="scan inline-flex items-center border border-gray-300 rounded-md px-12 py-12 shadow-sm text-2xl font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Scan Items
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            {{-- </div> --}}
          </div>
        </div>
        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG("14586325", 'C39+',1,33,array(0,0,0), true)}}" alt="barcode" />
    </body>

    {{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    {{-- end scripts --}}
</html>

</div>
