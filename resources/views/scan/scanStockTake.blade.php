@extends('layouts.app')

@section('content')

<div class="card1 mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="_stkPallet">
            <label for="stkPallet" class="sr-only">Pallet</label>
            <input type="text" name="stkPallet" id="stkPallet" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Pallet" autofocus />
        </div>

        <div class="_stkProducts" style="display: none">
            <label for="stkPallet" class="sr-only">Products</label>
            <input type="text" name="stkProduct" id="stkProduct" class="p-2 inline-flex text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:text-sm border-gray-300 rounded-md" placeholder="Scan Product" autofocus />
        </div>

        <div class="mt-2 text-center rounded-md">
            <span class="stk_take_message"></span>
        </div>
    </div>
</div>

<div class="card2 mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="flex gap-2 justify-between bg-white rounded-md py-1 mb-1">
            <span class="px-2 inline-flex">Pallet: <p class="px-2 p_name text-md font-medium"></p></span>
            <span class="inline-flex"> Location: <p class="px-2 loc_name text-md font-medium"></p></span>
        </div>
        <div>
            <table class="w-full border border-collapse border-black divide-y divide-black stk_Pallet_tbl">
                <thead class="bg-gray-100">
                    <tr class="px-2 text-center divide-x divide-black">
                        <td>Plu</td>
                        <td>Product name</td>
                        <td>Stock Qty</td>
                    </tr>
                </thead>
                <tbody class="items-center bg-white divide-y divide-gray-500 stk_Pallet_tbl_body">
                </tbody>
            </table>
        </div>
        <div class="_new_stock my-2" style="display: none">
            <table class="mb-2 w-full border border-collapse border-black divide-y divide-black new_stock">
                <thead class="bg-gray-100">
                    <tr class="px-2 text-center divide-x divide-black">
                        <td class="hidden">Label</td>
                        <td>PLU</td>
                        <td>Name</td>
                        <td scope="col" class="pl-1 pr-1 sm:pr-1">
                            <span class="sr-only">Edit</span>
                        </td>
                    </tr>
                </thead>
                <tbody class="items-center bg-white divide-y divide-gray-500 new_stock_body">
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            {{-- <button type="button" class="up_stk inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <span class="items-center mx-2">
                    &nbsp; Update &nbsp;
                </span>
            </button> --}}
            <button type="button" class="back_stk inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" style="display:none">
                <span class="items-center mx-2">
                    &nbsp; Back &nbsp;
                </span>
            </button>
            <button type="button" class="cmplt_stk inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" style="display:none">
                <span class="items-center mx-2">
                    &nbsp; Complete &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<div class="or_done mt-1 sm:mx-auto sm:w-full bg-white sm:max-w-lg" style="display: none">
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
