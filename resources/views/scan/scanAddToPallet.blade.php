@extends('layouts.app')

@section('content')
<div x-data="{addtopallet:true,prodtopallet:false,bbtn:false}" class="atp_card mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-1 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div x-show="addtopallet" class="_addtopallet mt-2">
            <label for="addtopallet" class="sr-only">Pallet</label>
            <input type="text" name="addtopallet" id="addtopallet" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Pallet" autofocus />
        </div>
        <div x-show="prodtopallet" class="_prodtopallet mt-2" style="display: none">
            <label for="prodtopallet" class="sr-only">Products</label>
            <input type="text" name="prodtopallet" id="prodtopallet" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Product" maxlength="60" autofocus />
        </div>

        <div class="mt-2 text-center bg-red-300 rounded-md">
            <span class="addtopallet_message"></span>
        </div>
    </div>

    <div class="px-4 py-1 mt-1 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-8 lg:px-8">
                <div class="inline-flex w-full bg-white my-1 rounded-md shadow ring-1 ring-black ring-opacity-5 md:rounded-md">
                    <p class="font-medium text-md px-6">Pallet Label:</p><p class="pallet_lbl ml-2" data-id=""></p>
                    <input type="hidden" id="cx" value="">
                </div>
                <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300 scprodtopallet">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Product Label</th>
                        {{-- <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">GTIN</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">PLU</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Name</th> --}}
                        <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="scprodtopallet_body">
                    {{-- tr here --}}
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <button x-show="bbtn" @click="addtopallet=!addtopallet,prodtopallet=!prodtopallet,bbtn=!bbtn" type="button" class="b_btn inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display: none">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button type="button" class="save_add2pallet inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Add &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<div class="or_done mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display: none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="or_done1 w-full rounded-lg text-center">
            <div class="pt-2">
                <div class="success mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100" style="display:none">
                    <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="error mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100" style="display:none">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="co_message py-5 text-xl rounded-md text-white"></p>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="button" class="cmplte_order inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Scan Again &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>


@endsection
