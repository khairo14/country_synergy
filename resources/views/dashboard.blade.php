@extends('layouts.app')
{{-- @extends('layouts.sidebar') --}}

@section('content')
{{-- Scan Page --}}
<div class="flex flex-col items-center justify-center min-h-full px-4 py-6 mx-auto sm:px-6 lg:px-8" >

    <div class="flex items-center justify-center row-start-1 space-y-8">
      <div>
        <img class="w-auto h-12 mx-auto" src="{{asset('img/country_synergy_logo.png')}}" alt="Workflow">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">Warehouse System</h2>
        <p class="mt-2 text-sm text-center text-gray-600">
      </div>
    </div>

    <div class="flex items-center justify-center min-w-full row-start-2">
        <div class="px-4">
            <button type="button" class="inline-flex items-center px-12 py-12 text-2xl font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm scan hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="flex items-center mx-5">
                    Scan
                </span>
            </button>
        </div>
        {{-- <div class="px-4">
            <button type="button" class="inline-flex items-center px-12 py-12 text-2xl font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm scan hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="flex items-center mx-5">
                    Scan out
                </span>
            </button>
        </div> --}}
    </div>
</div>
@endsection
