@extends('layouts.app')

@section('content')
<div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="_trnsfrPallet">
            <label for="trnsfrPallet" class="sr-only">Pallet</label>
            <input type="text" name="trnsfrPallet" id="trnsfrPallet" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Pallet" autofocus />
        </div>

        <div class="mt-0 _trnsfrloc" style="display: none">
            <label for="trnsfrloc" class="text-sm">Transfer to :</label>
            <input type="text" name="trnsfrloc" id="trnsfrloc" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm whitespace-nowrap" placeholder="Scan Location" autofocus>
        </div>

        <div class="mt-2 text-center rounded-md">
            <span class="trnsfrPallet_message"></span>
        </div>
    </div>

    <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="flex flex-col mt-1">
                <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
                    <div class="px-2 py-1 mt-1 sm:px-5 sm:mx-auto sm:w-full sm:max-w-lg">
                    <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 trnsfer_pallet">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 pl-2 pr-1 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Pallet</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Current Location</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">New Location</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="trnsfer_pallet_body">
                            <tr>
                                <td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6' data-id=""></td>
                                <td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap' data-id=""></td>
                                <td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap' data-id=""></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>

                <div class="flex justify-end mt-1 trnsf_btn" style="display: none">
                    <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md trnsfr_back text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="items-center mx-2">
                            &nbsp; Back &nbsp;
                        </span>
                    </button>
                    <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md trnsfr_save text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="items-center mx-2">
                            &nbsp; Save &nbsp;
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
