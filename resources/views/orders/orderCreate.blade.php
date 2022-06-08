@extends('layouts.app')

@section('content')
<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="py-5 overflow-hidden bg-white shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div class="grid grid-cols-4">
            <div class="ml-4">
                <label for="cx1" class="block text-sm font-medium text-gray-700">Select Customer</label>
                <select id="cx1" name="cx1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border border-gray-800 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option selected>Select Customers</option>
                    @if($customers != null)
                        @foreach ($customers as $cust)
                            <option value="{{$cust->id}}">{{$cust->name}}</option>
                        @endforeach
                    @else
                        <option selected>No Customers Found</option>
                    @endif
                </select>
                </div>
            <div class="ml-4">
                <label for="orderType" class="block text-sm font-medium text-gray-700">Order type</label>
                <select id="orderType" name="orderType" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border border-gray-800 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    {{-- <option value="In">In</option> --}}
                    <option Selected value="Out">Out</option>
                    <option value="In">In</option>
                </select>
            </div>
            <div class="grid row-start-2 my-2 ml-4">
                <div>
                    <label for="products" class="block text-sm font-medium text-gray-700">Select Products</label>
                    <select id="products" name="products" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border border-gray-800 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 row-start-2 my-2 ml-4">
                <div>
                    <label for="order_qty" class="block text-xs font-medium text-gray-700">Order Qty </label>
                    <input type="number" id="order_qty" value="" class="block w-24 py-1 pl-10 text-gray-900 border border-gray-300 rounded-md bg-gray-50 sm:text-sm focus:ring-blue-500 focus:border-blue-500" min="1" placeholder="0">
                </div>
                <div class="flex flex-row-reverse my-2">
                    <button type="button" class="items-center justify-center px-4 py-2 ml-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm add_or or_next2 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">Add</button>
                </div>
            </div>
            <div class="grid row-start-3 mx-4 mt-2 text-center rounded-md p2">
                <span class="or_message"></span>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="py-5 overflow-hidden bg-white shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="grid grid-cols-1">
                <table class="mx-4 divide-y divide-gray-500 or_tbl min-w-1/2">
                    <thead class="bg-gray-100">
                        <tr>
                        <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Product Code</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">GTIN</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Qty</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Delete</span>
                        </th>
                        </tr>
                    </thead>
                    <tbody class="items-center bg-white divide-y divide-gray-500 or_tbl_body">
                    </tbody>
                </table>
                <div class="flex flex-row-reverse my-4 mr-4">
                    <button type="button" class="items-center justify-center px-4 py-2 ml-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm add_order or_next2 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#products").select2();
    });
</script>
@endsection
