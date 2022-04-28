@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="my-2 ml-4">
        <label for="Company" class="block text-sm font-medium text-gray-700">Select Company</label>
        <select id="company" name="company" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="All" selected>All Orders</option>
            @if($company != null)
                @foreach ($company as $comp)
                    <option value="{{$comp->id}}">{{$comp->name}}</option>
                @endforeach
            @else
                <option selected>No Customers Found</option>
            @endif
        </select>
    </div>

    <div class="w-full" id="pr_tbl">
        <table class="ml-4 divide-y divide-gray-500 min-w-1/2" id="pr_tbl_body">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Order #</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Order Type</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Code</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Quantity</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Picked</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Dispatch Date</th>
                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Status</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="pr_tbl_body items-center bg-white divide-y divide-gray-500">
            </tbody>
        </table>
    </div>
</div>
@endsection
