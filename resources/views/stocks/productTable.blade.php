<div class="flex justify-end mt-4">
    <button type="button" class="print-product inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
        <span class="items-center mx-2">
            &nbsp; Print &nbsp;
        </span>
    </button>
</div>

<table class="min-w-full divide-y divide-gray-300" id="prod-tbl">
    <thead class="bg-gray-50">
        <tr>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">Product Code</th>
        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Barcode</th>
        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Name</th>
        <th scope="col" class="px-3 py-3 text-left text-xs invisible sm:visible font-medium uppercase tracking-wide text-gray-500">Best Before/Production</th>
        <th scope="col" class="px-3 py-3 text-left text-xs invisible sm:visible font-medium uppercase tracking-wide text-gray-500">Received Date</th>
        {{-- <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6 invisible sm:visible">
            <span class="sr-only">Edit</span>
        </th> --}}
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        <input type="hidden" class="pallet_name" value="{{$pallet[0]->name}}">
        @if($products != "")
            @foreach ($products as $product)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$product['plu']}}</td>
                    <td class="whitespace-nowrap px-3 py-4+ text-sm text-gray-500">
                        <p class='w-24 sm:w-24 truncate overflow-clip'>{{$product['label']}}</p>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$product['name']}}</td>
                    <td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>{{$product['date']}}</td>
                    <td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>{{$product['rcvd']}}</td>
                    {{-- <td class="relative whitespace-nowrap invisible sm:visible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6">
                        <a href="#" onlclick="event" id="" class="stock_print text-indigo-600 hover:text-indigo-900">Print</a>
                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
