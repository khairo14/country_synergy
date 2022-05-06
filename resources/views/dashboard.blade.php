@extends('layouts.app')
{{-- @extends('layouts.sidebar') --}}
@section('content')
{{-- Scan Page --}}
<div class="flex flex-col items-center justify-center min-h-full px-2 py-4 mx-auto sm:px-2 lg:px-8" >
    <div class="grid items-center justify-center min-w-full grid-rows-1 space-y-6">
        <div class="grid-rows-2 px-4">
            <button type="button" class="inline-flex items-center px-10 py-10 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md stockIn hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    &nbsp;Stocks In &nbsp;
                </span>
            </button>
        </div>
        <div class="px-4">
            <button type="button" class="inline-flex items-center px-10 py-10 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md stockOut hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    Stocks Out
                </span>
            </button>
        </div>
    </div>
</div>
@endsection
