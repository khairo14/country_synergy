@extends('layouts.app')

@section('content')
<div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="_addtopallet">
            <label for="addtopallet" class="sr-only">Pallet</label>
            <input type="text" name="addtopallet" id="addtopallet" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Pallet" autofocus />
        </div>

        <div class="mt-2 text-center bg-red-300 rounded-md">
            <span class="addtopallet_message"></span>
        </div>
    </div>
</div>


@endsection
