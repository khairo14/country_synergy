@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="my-2 ml-4">
        <label for="Company" class="block text-sm font-medium text-gray-700">Select Company</label>
        <select id="company" name="company" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="0" selected>All Orders</option>
            @if($company != null)
                @foreach ($company as $comp)
                    <option value="{{$comp->id}}">{{$comp->name}}</option>
                @endforeach
            @else
                <option selected>No Customers Found</option>
            @endif
        </select>
    </div>

    <div class="w-full">
        <table class="ml-4 divide-y divide-gray-500 pr_tbl min-w-1/2">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Order #</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Order Type</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Code</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Quantity</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Dispatch Date</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Status</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="items-center bg-white divide-y divide-gray-500 pr_tbl_body">
            @if(isset($orders))
            {{-- @dd($orders) --}}
            @foreach ($orders as $order)
                <tr>
                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{$order['order_id']}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$order['or_typ']}}</td>
                    {{-- @endif --}}

                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <div class="grid grid-rows">
                            @foreach ($order['0'] as $product)
                              <span class="w-full px-2 py-1">{{$product->products->product_code}}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <div class="grid grid-rows">
                            @foreach ($order['0'] as $product)
                              <span class="w-full px-2 py-1">{{$product->products->product_name}}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <div class="grid grid-rows">
                            @foreach($order['0'] as $qty)
                                <span class="w-full px-2 py-1">{{$qty->qty}}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{date('d-m-Y',strtotime($order['dispatch']))}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">Place Status Here</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                    <button type='button' class='edit_orders' data-val="{{$order['order_id']}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
