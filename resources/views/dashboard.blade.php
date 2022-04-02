@extends('layouts.app')
{{-- @extends('layouts.sidebar') --}}

@section('content')
{{-- Scan Page --}}
<div class="mx-auto min-h-full flex flex-col items-center justify-center py-6 px-4 sm:px-6 lg:px-8" >

    <div class="flex row-start-1 items-center space-y-8 justify-center">
      <div>
        <img class="mx-auto h-12 w-auto" src="{{asset('img/country_synergy_logo.png')}}" alt="Workflow">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Warehouse System</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
      </div>
    </div>

    <div class="flex min-w-full row-start-2 items-center justify-center">
        <div class="px-4">
            <button type="button" class="scan inline-flex items-center border border-gray-300 rounded-md px-12 py-12 shadow-sm text-2xl font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="mx-5 flex items-center">
                    Scan In
                </span>
            </button>
        </div>
        <div class="px-4">
            <button type="button" class="scan inline-flex items-center border border-gray-300 rounded-md px-12 py-12 shadow-sm text-2xl font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="mx-5 flex items-center">
                    Scan out
                </span>
            </button>
        </div>
    </div>
</div>
@endsection
