@extends('layouts.app')

@section('content')
<div>
    <dl class="grid w-full grid-cols-1 mt-5 space-x-2 sm:grid-cols-2 sm:w-full" id="p0">
        <div class="grid grid-cols-4 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6" id="p1">
            <div class="w-full col-span-2 p-4 mx-auto">
                <dt class="text-sm font-medium text-gray-500 truncate"># Products</dt>
                <dd class="mt-3 text-4xl font-semibold text-gray-900">{{$counter}}</dd>
            </div>
        </div>
        <div x-data="{addproduct:false}" class="hidden mx-auto sm:block">
            <div class="grid grid-cols-4 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6" id="p1">
                <div class="w-full col-span-2 mx-auto">
                    <div class="">
                        <label for="prod_comp" class="block text-xs font-medium text-gray-700">Select Customer</label>
                        <select id="prod_comp" name="prod_comp" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                            @if($customers->isNotEmpty())
                                @foreach ($customers as $cust)
                                    <option value="{{$cust->id}}">{{$cust->name}}</option>
                                @endforeach
                            @else
                                <option selected value="0">No Customer Available</option>
                            @endif
                        </select>
                    </div>

                    <span class="inline-flex w-full px-4 mt-4 text-sm font-medium bg-gray-200 rounded-md message3" style="display:none">asd</span>
                </div>
                <div class="grid justify-end col-span-2 col-start-3 grid-rows-2 px-6 py-6 my-2 space-y-1 sm:py-6">
                    <label for="prod_upload" class="inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Upload
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <input id="prod_upload" name="prod_upload" type="file" class="sr-only">
                      </label>
                    <button @click="addproduct=!addproduct" dtype="button" class="inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        &nbsp;&nbsp;&nbsp;&nbsp;Add
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
            @include('products.productAdd')
        </div>
    </dl>

    <div class="flex flex-col mt-2 border border-gray-200 rounded-md h-min-full">
        <div class="grid grid-cols-4">
            <div>
                <label for="filter_prod" class="block text-xs font-medium text-gray-700">Select Products</label>
                <select id="filter_prod" name="filter_prod" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                    {{-- @if($loc->isNotEmpty())
                        <option value="0">Select Name</option>
                        @foreach ($loc as $l)
                            <option value="{{$l->id}}">{{$l->name}}</option>
                        @endforeach
                    @else --}}
                        <option selected>No Products Available</option>
                    {{-- @endif --}}
                </select>
            </div>
            <div>
                <label for="filter_comp" class="block text-xs font-medium text-gray-700">Select Customer</label>
                <select id="filter_comp" name="filter_comp" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                    @if($customers->isNotEmpty())
                        @foreach ($customers as $cust)
                            <option value="{{$cust->id}}">{{$cust->name}}</option>
                        @endforeach
                    @else
                        <option selected value="0">No Customer Available</option>
                    @endif
                </select>
            </div>
            <div>
                <button type="button" class="mt-2.5 inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Search
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-data="{editproduct:false}" class="overflow-y-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" id="pr_table">
              <table class="min-w-full divide-y divide-gray-300" id="pr_table_body">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">PLU</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left hidden sm:table-cell text-sm font-semibold text-gray-900">GTIN</th>
                    <th scope="col" class="px-3 py-3.5 text-left hidden sm:table-cell text-sm font-semibold text-gray-900">Brand</th>
                    <th scope="col" class="px-3 py-3.5 text-left hidden sm:table-cell text-sm font-semibold text-gray-900">Desc</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <!-- Odd row -->
                  @foreach ($products as $product )
                    <tr>
                      <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{$product->product_code}}</td>
                      <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product->product_name}}</td>
                      <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap">{{$product->gtin}}</td>
                      <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap">{{$product->brand}}</td>
                      <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap">{{$product->description}}</td>
                      <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-left whitespace-nowrap sm:pr-6">
                        <a href="" onclick="event.preventDefault()" @click="editproduct=!editproduct" class="inline-flex text-indigo-600 prod_edit hover:text-indigo-900" data="{{$product->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            &nbsp; Edit
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
            @include('products.productEdit')
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){
        $("#prod_comp").select2();
        $("#filter_prod").select2();
        $("#filter_comp").select2();
    });
</script>
@endsection
{{-- @section('productAdd') --}}
{{-- @endsection --}}
