@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
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

    <div class="w-full" id="pr_tbl">
        <table class="ml-4 divide-y divide-gray-500 min-w-1/2" id="pr_tbl">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Order #</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">PLU</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">Picked Qty</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">Ordered Qty</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Dispatch Date</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">Invoice Id</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Status</th>
            </tr>
            </thead>
            <tbody class="items-center bg-white divide-y divide-gray-500 pr_tbl_body">
                @foreach ($orders as $order)
                    <tr>
                        <td class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase sm:pl-6">
                            <a href="{{url('/orders/get-order/'.$order['or_id'])}}" class="font-medium text-red-600 text-md">{{$order['or_id']}}</a>
                        </td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">
                            @forelse ($order['lines'] as $line)
                                @if($line['or_plu'] != ""){{$line['or_plu']}}</br>@else{{$line['sc_plu']}}</br>@endif
                            @empty @endforelse
                        </td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                            @forelse ($order['lines'] as $line)
                                @if($line['or_prod_name'] != ""){{$line['or_prod_name']}}</br>@else{{$line['sc_prod_name']}}</br>@endif
                            @empty @endforelse
                        </td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">
                            @forelse ($order['lines'] as $line){{$line['sc_qty']}}</br>@empty @endforelse
                        </td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">
                            @forelse ($order['lines'] as $line){{$line['or_qty']}}</br>@empty @endforelse
                        </td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$order['dispatch']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$order['inv_id']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$order['status']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
