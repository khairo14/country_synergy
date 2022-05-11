@extends('layouts.app')

@section('content')
<div x-data="{qstion:true, scnpallet:false, slct_cust:false, scnproducts:false, prod_printLabel:false, assign:false, labelModal:false}">
<div x-show="qstion" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="py-5 text-center bg-white rounded-lg flex-inline">
            <span class="p-4 text-lg font-medium">Pallet Label Exist?</span>
            <div>
                <button @click="scnpallet=!scnpallet,qstion=!qstion" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; Yes &nbsp;
                    </span>
                </button>

                <button @click="slct_cust=!slct_cust,qstion=!qstion" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; No &nbsp;
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<div x-show="scnpallet" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="border border-gray-400 rounded-md">
            <label for="scan_pcode" class="sr-only">Pallet Label</label>
            <input type="text" name="scan_oldplabel" id="scan_oldplabel" class="block w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Pallet Label" autofocus>
        </div>
        <div class="flex justify-end mt-2">
            <button @click="scnpallet=!scnpallet,qstion=!qstion" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button @click="slct_cust=!slct_cust,scnpallet=!scnpallet" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; next &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<div x-show="slct_cust" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="mt-2">
            <label for="exist_cust1" class="block text-xs font-medium text-gray-700">Select Customer</label>
            <select id="exist_cust1" name="exist_cust1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                @if($customers->isNotEmpty())
                    @foreach ($customers as $cust)
                        <option value="{{$cust->id}}">{{$cust->name}}</option>
                    @endforeach
                @else
                    <option selected value="0">No Customer Available</option>
                @endif
            </select>
        </div>

        <div class="flex justify-end mt-2">
            <button @click="slct_cust=!slct_cust,qstion=!qstion" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button @click="scnproducts=!scnproducts,slct_cust=!slct_cust" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; next &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<div x-show="scnproducts" id="scnproducts" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="border border-gray-400 rounded-md">
            <label for="scan_pcode" class="sr-only">PLU</label>
            <input type="text" name="scan_pcode" id="scan_pcode" class="block w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm no-white" placeholder="Scan Product" autofocus>
        </div>
        <div class="mt-1 text-center bg-red-300 rounded-md p2">
            <span class="scan_pcode_message"></span>
        </div>
        <div class="flex flex-col mt-2">
            <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-8 lg:px-8">
                <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300 scnproducts">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">GTIN</th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">PLU-Name</th>
                        <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="scnproducts_body">
                      {{-- tr here --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-end mt-2">
            <button @click="scnproducts=!scnproducts,slct_cust=!slct_cust" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button @click="labelModal=!labelModal" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Generate Pallet &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<div x-show="prod_printLabel" id="prod_printLabel" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        {{-- for displaying pallet label --}}
       <div>
          <span class="pallet_label">a</span>
          <span class="qty">a</span>
          <span class="date">a</span>
          <span class="gtin">a</span>
       </div>
    <div class="flex justify-end mt-2">
        <button @click="prod_printLabel=!prod_printLabel,assign=!assign" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="items-center mx-2">
                &nbsp; Assign &nbsp;
            </span>
        </button>
    </div>
    </div>
</div>

<div x-show="assign" id="assign" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">

        <div class="flex text-center border border-gray-400 rounded-md">
            <label for="scan_location" class="sr-only">location</label>
            <input type="hidden" id="pallet_id" value=""/>
            <input type="hidden" id="qty" value=""/>
            <input type="hidden" id="gtin" value=""/>
            <input type="text" name="scan_location" id="scan_location" class="flex text-center w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm no-white" placeholder="Scan Location" autofocus>
        </div>

        <div class="mt-1 text-center bg-red-300 rounded-md p2">
            <span class="scan_location_message"></span>
        </div>

        <div class="flex justify-end mt-2">
            <button @click="prod_printLabel=!prod_printLabel,assign=!assign" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Back &nbsp;
                </span>
            </button>
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md assign text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <span class="items-center mx-2">
                    &nbsp; Assign & Complete &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

@include('scan.scanModal')

</div>

<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
    });
</script>
@endsection

