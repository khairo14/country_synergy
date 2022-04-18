@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Products</h1>
      {{-- combo box--}}
        <div class="w-64 sm:flex-auto">
            <div class="relative mt-1" x-data="{open:false, input:'', cm_id:'',cm_name:''}">
            <input type="text" id="cm_prods" class="w-full py-2 pl-3 pr-12 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" role="combobox" aria-controls="options" :aria-expanded="open" @click = "open = !open" x-model="input" :data="cm_id" placeholder="Select Customer">
            <button type="button" class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none" @click ="open = !open" aria-label="btn-options">
                <!-- Heroicon name: solid/selector -->
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox" x-show="open" x-ref="option" @click.away="open = false" aria-label="options">
                @foreach ($customers as $customer)
                <li class="relative py-2 pl-3 text-gray-900 cursor-default pr-9 hover:text-indigo-600" id="option-0" role="option" tabindex="-1" @click="cm_id='{{$customer->id}}',input='{{$customer->name}}'" :class="{'text-indigo-600' : cm_id === '{{$customer->id}}'}" :id="'options-{{$customer->id}}'">
                <span class="block truncate" @click="cm_id='{{$customer->id}}',input='{{$customer->name}}'" :class="{'font-semibold' : cm_id === '{{$customer->id}}','font-normal': !(cm_id === '{{$customer->id}}')}" >{{$customer->name}}</span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 hover:text-indigo-600" :class="{'text-indigo-600' : cm_id === '{{$customer->id}}', 'text-white' : !(cm_id === '{{$customer->id}}')}">
                        <!-- Heroicon name: solid/check -->
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                @endforeach
            </ul>
            </div>
        </div>

      {{-- end combo --}}
      </div>
      <div class="mt-4 ul sm:mt-8 sm:ml-16 sm:flex-none" x-data="{modal:false, cm_id:''}">
        <button type="button" @click="modal=!modal" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm up_prods hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Upload Products</button>
        {{-- <button type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm ad_prods hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add Products</button> --}}
        @include('products.productUpload')
        </div>
    </div>
    <div class="flex flex-col mt-8">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg" id="pr_table">
            <table class="min-w-full divide-y divide-gray-300" id="pr_table_body">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Product Code</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">GTIN</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Brand</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Desc</th>
                  {{-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th> --}}
                </tr>
              </thead>
              <tbody class="bg-white">
                <!-- Odd row -->
                @foreach ($products as $product )
                  <tr>
                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{$product->product_code}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product->product_name}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product->gtin}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product->brand}}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{$product->description}}</td>
                    {{-- <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                    </td> --}}
                  </tr>
                @endforeach


                <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
