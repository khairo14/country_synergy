@extends('layouts.app')

@section('content')
    @include('orders.orderAlert')
   <!-- This example requires Tailwind CSS v2.0+ -->
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Create Order</h1>
      </div>
      <div class="mt-2 ul sm:mt-4 sm:ml-16 sm:flex-none">
        {{-- <button type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</button> --}}
      </div>
    </div>
    <div class="flex flex-col mt-8">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="py-5 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="or_p1">
              <div class="my-2 ml-4">
                <label for="OrderType" class="block text-sm font-medium text-gray-700">Select Order type</label>
                <select id="OrderType" name="OrderType" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option selected value="In">In</option>
                  <option value="Out">Out</option>
                </select>
              </div>
              <div class="my-2 ml-4">
                <label for="Company" class="block text-sm font-medium text-gray-700">Select Company</label>
                <select id="company" name="company" class="block w-64 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @if($company != null)
                        @foreach ($company as $comp)
                            <option value="{{$comp->id}}">{{$comp->name}}</option>
                        @endforeach
                    @else
                        <option selected>No Customers Found</option>
                    @endif
                </select>
              </div>
              <div class="flex flex-row-reverse my-4 mr-4">
                <button type="button" class="items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm or_next hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Next</button>
              </div>
            </div>

            <div class="or_p2" hidden>
                <div class="items-center my-2 ml-4 w-min-full">
                    <div class="inline-block">
                    <label for="products" class="block text-sm font-medium text-gray-700">Select Product</label>
                        <select id="products" name="products" class="block w-64 h-5 py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md products focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            {{-- <option value="WY">Wyoming</option> --}}
                        </select>
                    </div>
                    <div class="inline-block">
                    <label for="pr_qty" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="text" name="pr_qty" id="pr_qty" class="block w-32 text-center border border-gray-500 rounded-sm shadow-sm h-7 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter Quantity">
                    </div>
                      <button type="button" class="inline-flex items-center p-1 -mb-4 text-white bg-indigo-600 border border-transparent shadow-sm add_pr hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <!-- Heroicon name: solid/plus-sm -->
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                      </button>
                </div>
                <table class="ml-4 divide-y divide-gray-500 pr_tbl min-w-1/2">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Product_code</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product_name</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Qty</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Edit</span>
                          </th>
                      </tr>
                    </thead>
                    <tbody class="items-center bg-white divide-y divide-gray-500 pr_tbl_body">
                      {{-- <tr>
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">01</td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">Whole Bird</td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">5</td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <button type='button' class='rm_pr'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                <path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                            </svg>
                        </button>
                        </td>
                      </tr> --}}
                    </tbody>
                </table>
                <div class="flex flex-row-reverse my-4 mr-4">
                    <button type="Submit" class="items-center justify-center px-4 py-2 ml-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm or_next2 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">Save</button>
                    <button type="button" class="items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm or_back hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Back</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
