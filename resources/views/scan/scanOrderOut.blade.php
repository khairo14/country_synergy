@extends('layouts.app')

@section('content')
<div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="orderout">
            <label for="orderout" class="sr-only">Order #</label>
            <input type="text" name="orderout" id="orderout" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter Order #" autofocus />
        </div>
        <div class="prod_or_out" style="display: none">
            <label for="orderout" class="sr-only">Products</label>
            <input type="text" name="orderout_prod" id="orderout_prod" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Products" autofocus />
        </div>
        <div class="mt-2 text-center rounded-md">
            <span class="orderout_message"></span>
        </div>
    </div>
</div>

<div class="mt-1 order_dtls sm:mx-auto sm:w-full sm:max-w-lg" style="display: none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div>
            <label for="orderout" data-id="" class="or_num"></label>
            <table class="w-full border border-collapse border-black divide-y divide-black or_out_tbl">
                <thead class="bg-gray-100">
                    <tr class="px-2 text-center divide-x divide-black">
                        <td>Plu</td>
                        <td>Product name</td>
                        <td>Order Qty</td>
                        <td>Picked Qty</td>
                    </tr>
                </thead>
                <tbody class="items-center bg-white divide-y divide-gray-500 or_out_tbl_body">
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
