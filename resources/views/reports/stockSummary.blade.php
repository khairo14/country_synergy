@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="justify-items-start row-start-1 flex grid-cols-2 space-x-1">
        <div class="my-2 ml-4">
            <label for="cust1" class="block text-sm font-medium text-gray-700">Orders From:</label>
            <select id="cust1" name="cust1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                {{-- <option value="All" selected>All Orders</option> --}}
                @if($customers != null)
                    @foreach ($customers as $cust)
                        <option value="{{$cust->id}}">{{$cust->name}}</option>
                    @endforeach
                @else
                    <option selected>No Customers Found</option>
                @endif
            </select>
        </div>
        <div class="mt-4">
            <button type="button" class="print_summary inline-flex items-center mt-4 px-1 py-2 text-sm font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span class="items-center mx-2">
                    &nbsp; Print &nbsp;
                </span>
            </button>
        </div>
    </div>
    <div class="w-full" id="pr_tbl">
        <table class="ml-4 divide-y divide-gray-500 min-w-1/2" id="stk_sum_tbl">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">PLU</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">Total Qty</th>
            </tr>
            </thead>
            <tbody class="items-center bg-white divide-y divide-gray-500 stk_sum_tbl_body">
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase sm:pl-6">{{$stock['plu']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$stock['name']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$stock['count']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
