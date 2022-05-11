@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-full px-2 py-4 mx-auto sm:px-2 lg:px-8" >
    <div class="grid items-center justify-center min-w-full grid-rows-1 space-y-6">
        <div class="grid-rows-2 px-4">
            <a href="{{url('/home/scan/products')}}" class="inline-flex items-center px-4 py-8 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md sm:px-6 sm:py-12 stockIn hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    Scan Product
                </span>
            </a>
        </div>
        <div class="px-4">
            <button type="button" class="inline-flex items-center px-4 py-8 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md sm:px-6 sm:py-12 stockOut hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    &nbsp; Scan Pallet &nbsp;
                </span>
            </button>
        </div>
        <div class="px-4">
            <button type="button" class="inline-flex items-center px-4 py-8 text-2xl font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md sm:px-6 sm:py-12 stockOut hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-5">
                    &nbsp; Scan Order &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>
@endsection
