@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="my-2">
        <label for="pallet1" class="block text-sm font-medium text-gray-700">Products From:</label>
        <select id="pallet1" name="pallet1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="{{$pallet[0]->id}}" selected>{{$pallet[0]->name}}</option>
            @if($pallets != null)
                @foreach ($pallets as $p)
                    <option value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            @else
                <option selected>No Customers Found</option>
            @endif
        </select>
        {{-- <div class="flex justify-end mt-4"> --}}
            <button type="button" class="print_palletProds inline-flex items-center px-1 py-1 text-sm font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-1 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <span class="items-center mx-2">
                    &nbsp; Print &nbsp;
                </span>
            </button>
        {{-- </div> --}}
    </div>

    <div class="w-full" id="pr_tbl">
        <table class="min-w-full divide-y divide-gray-300 rounded-md" id="prod-tbl">
            <thead class="rounded-md bg-gray-50">
                <tr class="rounded-md">
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Plu</th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Label</th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Name</th>
                <th scope="col" class="hidden px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">GTIN</th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Weight</th>
                <th scope="col" class="invisible px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:visible">Best Before</th>
                <th scope="col" class="invisible px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:visible">Received Date</th>
                <th scope="col" class="invisible px-1 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:visible">
                    <span class="">Move / Delete</span>
                </th>
                </tr>
            </thead>
            <tbody class="items-center bg-white divide-y divide-gray-200 prod-tbl-body">
                {{-- <input type="hidden" class="pallet_name" value="{{$pallet[0]->name}}"> --}}
                @if($products != "")
                    @foreach ($products as $product)
                        <tr>
                            <td data-tableexport-msonumberformat="0" class="py-1 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{$product['plu']}} </td>
                            <td class="px-1 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product['label']}} </td>
                            <td class="px-1 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product['name']}}</td>
                            <td class="hidden px-1 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product['gtin']}} </td>
                            <td class='invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>{{$product['weight']}} Kg</td>
                            <td class='invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>{{$product['best_before']}}</td>
                            <td class='invisible px-1 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>{{$product['rcvd']}}</td>
                            <td class="relative flex flex-row invisible py-4 pl-3 pr-4 text-sm font-medium text-left whitespace-nowrap sm:visible sm:pr-6">
                                <a href="#" id="" class="px-2 text-green-600 hover:text-green-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </a>
                                <a href="#" id="" class="px-2 text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


<script>
$(document).ready(function(){
    $("#pallet1").select2();
});
</script>
@endsection
