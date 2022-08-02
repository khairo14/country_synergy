@extends('layouts.app')

@section('content')
<div class="mt-4">
    <button type="button" class="inline-flex items-center px-1 py-1 text-sm font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md print_detailed text-md sm:px-2 sm:py-1 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
        <span class="items-center mx-2">
            &nbsp; Print &nbsp;
        </span>
    </button>
</div>
<div>
    <table class="min-w-full divide-y divide-gray-300" id="stcks_tbl">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Pallet Name</th>
            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Barcodes</th>
            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Weight</th>
            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Best Before/Production</th>
            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Qty</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200" id="stcks_tbl_body">
        @forelse ($products as $product)
            <tr>
                <td class="py-1 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{$product['pallet_name']}}</td>
                <td class="py-1 text-sm font-medium text-gray-900 whitespace-nowrap">
                    @foreach ($product['products'] as $item)
                        {{$item['barcode']}}</br>
                    @endforeach
                </td>
                <td class="py-1 text-sm font-medium text-gray-900 whitespace-nowrap">
                    @foreach ($product['products'] as $item)
                        {{$item['name']}}</br>
                    @endforeach
                </td>
                <td class="py-1 text-sm font-medium text-gray-900 whitespace-nowrap">
                    @foreach ($product['products'] as $item)
                        {{$item['weight']}}</br>
                    @endforeach
                </td>
                <td class="py-1 text-sm font-medium text-gray-900 whitespace-nowrap">
                    @foreach ($product['products'] as $item)
                        {{$item['date']}}</br>
                    @endforeach
                </td>
                <td class="py-1 text-sm font-medium text-gray-900 whitespace-nowrap">{{$product['pallet_count']}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                    No Items Scanned Today - Please Select date / Scan an Item
                </td>
            </tr>
        @endforelse
    </tbody>
    </table>
</div>
<div>
    <nav class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
        {{$products->links()}}
    </nav>
</div>
@endsection
