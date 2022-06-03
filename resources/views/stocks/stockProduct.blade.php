@extends('layouts.app')

@section('content')
<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
        <tr>
        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">Plu</th>
        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Label</th>
        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Name</th>
        <th scope="col" class="px-3 py-3 text-left text-xs invisible sm:visible font-medium uppercase tracking-wide text-gray-500">Best Before</th>
        <th scope="col" class="px-3 py-3 text-left text-xs invisible sm:visible font-medium uppercase tracking-wide text-gray-500">Received Date</th>
        {{-- <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6 invisible sm:visible">
            <span class="sr-only">Edit</span>
        </th> --}}
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        @foreach ($products as $product)
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$product['plu']}}</td>
                <td class="whitespace-nowrap px-3 py-4+ text-sm text-gray-500">
                    <p class='w-24 sm:w-24 truncate overflow-clip'>{{$product['label']}}</p>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$product['name']}}</td>
                <td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>{{$product['best_before']}}</td>
                <td class='whitespace-nowrap px-3 py-4 invisible sm:visible text-sm text-gray-500'>{{$product['rcvd']}}</td>
                {{-- <td class="relative whitespace-nowrap invisible sm:visible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6">
                    <a href="#" onlclick="event" id="" class="stock_print text-indigo-600 hover:text-indigo-900">Print</a>
                </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
