@extends('layouts.app')
{{-- @extends('layouts.sidebar') --}}
@section('content')
{{-- Scan Page --}}
<div class="flex flex-col items-center justify-center min-h-full px-2 py-4 mx-auto sm:px-2 lg:px-8" >
    <div class="grid items-center justify-center min-w-full grid-rows-1 space-y-6">
        <div class="grid-rows-2 px-4">
            <a href="{{url('/home/scan-in')}}" class="inline-flex items-center px-10 py-10 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md stockIn hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    &nbsp;Scan In &nbsp;
                </span>
            </a>
        </div>
        <div class="px-4">
            <a href="{{url('/home/scan-out')}}" class="inline-flex items-center px-10 py-10 text-2xl font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md stockOut hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    Scan Out
                </span>
            </a>
        </div>
        <div class="px-4">
            <a href="{{url('/home/transfer')}}" class="inline-flex items-center px-10 py-10 text-2xl font-medium text-white bg-red-400 border border-red-300 rounded-md shadow-md transfer hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    Transfer &nbsp;
                </span>
            </a>
        </div>
        <div class="px-4">
            <a href="{{url('/home/stock-take')}}" class="inline-flex items-center px-8 py-10 text-2xl font-medium text-white bg-red-400 border border-red-300 rounded-md shadow-md stockTake hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    Stock Take
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
