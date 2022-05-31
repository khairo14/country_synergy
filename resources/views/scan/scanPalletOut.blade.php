@extends('layouts.app')

@section('content')
<div x-data="{cx:true,pallet_out:true}">
    {{-- <div x-show="cx" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="mt-2 flex justify-center">
                <div>
                <label for="exist_cust1" class="block text-xs font-medium text-gray-700">Select Customer</label>
                <select id="exist_cust1" name="exist_cust1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                    @if($customers->isNotEmpty())
                        @foreach ($customers as $cust)
                            <option value="{{$cust->id}}">{{$cust->name}}</option>
                        @endforeach
                    @else
                        <option selected value="0">No Customer Available</option>
                    @endif
                </select>
                </div>
            </div>

            <div class="flex justify-center mt-2">
                <button @click="cx=!cx,pallet_out=!pallet_out" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; next &nbsp;
                    </span>
                </button>
            </div>
        </div>
    </div> --}}
    <div x-show="pallet_out">
    <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="_scnpalletout">
                <label for="scnpalletout" class="sr-only">Pallet</label>
                <input type="text" name="scnpalletout" id="scnpalletout" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Pallet" autofocus />
            </div>
            <div class="mt-2 text-center bg-red-300 rounded-md">
                <span class="scan_pallet_message"></span>
            </div>
        </div>
    </div>

    <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="flex flex-col mt-2">
                <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
                    <div class="mt-1 py-2 px-4 sm:px-5 sm:mx-auto sm:w-full sm:max-w-lg">
                    <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 scnpalletout_tbl">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Quantity</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Location</th>
                                <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="scnpalletout_tbl_body">
                            <tr>
                                <td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>
                                    <p class='w-36 sm:w-64 truncate overflow-clip'></p>
                                </td>
                                <td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>
                                <td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>
                                <td class='relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6'>
                                    <a href='#' onclick='event.preventDefault()' class='rm_pallet text-indigo-600 hover:text-indigo-900'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>"
                                            <path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />"
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; Pull Out &nbsp;
                    </span>
                </button>
            </div>
        </div>
    </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
    });
</script>
@endsection
