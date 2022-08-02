@extends('layouts.app')

@section('content')
<div x-data="{pallet_out:true, docket:false}">
    <div x-show="pallet_out" id="scannerOut">
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
        <div class="px-1 py-2 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="flex flex-col mt-1">
                <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
                    <div class="py-1 px-0 sm:px-5 sm:mx-auto sm:w-full sm:max-w-lg">
                    <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 scnpalletout_tbl">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-2 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Quantity</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Location</th>
                                <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="scnpalletout_tbl_body">
                            {{-- this place body --}}
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" class="tk_out inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; Create Order &nbsp;
                    </span>
                </button>
            </div>
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

</div>

<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
    });
</script>
@endsection
