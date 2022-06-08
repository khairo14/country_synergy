@extends('layouts.app')

@section('content')
<div class="grid w-full grid-cols-1 mt-1 sm:grid-cols-1 sm:w-full">
    <div class="grid grid-cols-1 px-4 bg-white rounded-lg shadow overflow-none sm:p-6">
        <div class="grid grid-cols-4">
            <div class="grid grid-cols-1 col-span-2 grid-rows-1">
                <div class="flex items-center h-6">
                    <label for="order" class="text-sm font-medium text-gray-700 sr-only flex-inline">Order # </label>
                    <p class="px-2 text-gray-700">Order #</p>
                    <p class="block px-2 font-medium text-blue-500 flex-inline">{{$orders[0]->id}}</p>
                </div>
                <div class="mt-2 bg-green-200 shadow overflow-none">
                    <table class="w-full border border-collapse border-black divide-y divide-black">
                        <thead class="bg-gray-100">
                            <tr class="px-2 text-center divide-x divide-black">
                                <td>Plu</td>
                                <td>Product name</td>
                                <td>Order Qty</td>
                                <td>Picked Qty</td>
                            </tr>
                        </thead>
                        <tbody class="items-center bg-white divide-y divide-gray-500">
                            @foreach ($or_lines as $line)
                                <tr class="px-2 text-center divide-x divide-black">
                                    @if($line['or_plu'] != "")
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['or_plu']}}</td>
                                    @else
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['sc_plu']}}</td>
                                    @endif

                                    @if($line['or_prod_name'] != "")
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['or_prod_name']}}</td>
                                    @else
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['sc_prod_name']}}</td>
                                    @endif

                                    @if($line['or_qty'] != "")
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['or_qty']}}</td>
                                    @else
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">0</td>
                                    @endif

                                    @if($line['sc_qty'] != "")
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$line['sc_qty']}}</td>
                                    @else
                                    <td class="px-2 py-2 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">0</td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 px-4 mt-5 bg-white rounded-lg shadow overflow-none sm:p-6" id="pr_tbl">
        <h5 class="w-1/6 ml-4 font-medium text-center bg-gray-100">List of Scan Products</h5>
        <table class="ml-4 divide-y divide-gray-500 min-w-1/2" id="pr_tbl_body">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">PLU</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Weight</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Description</th>
                {{-- <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Dispatch Date</th> --}}
                {{-- <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">Invoice Id</th> --}}
                 {{-- <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Status</th> --}}
            </tr>
            </thead>
            <tbody class="items-center bg-white divide-y divide-gray-500 pr_tbl_body">
                @foreach ($products as $product)
                    <tr>
                        <td class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">{{$product['label']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase">{{$product['plu']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$product['name']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$product['weight']}}</td>
                        <td class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">{{$product['desc']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
        $("#exist_cust2").select2();
    });
</script>
@endsection
