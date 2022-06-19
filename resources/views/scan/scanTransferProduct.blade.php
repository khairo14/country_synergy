@extends('layouts.app')

@section('content')
<div x-data="{prod:true,exist1:false,exist2:false,back:false,btn1:true,btn2:true,cmplt1:false,cmplt2:false}" id="trnsfr_crd" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div x-show="prod" class="rounded-md">
            <label for="trnsfr_prod" class="block text-xs font-medium text-gray-700 ml-2">Scan Products</label>
            <input type="text" name="trnsfr_prod" id="trnsfr_prod" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Products" autofocus >
        </div>
        <div x-show="exist1" class="rounded-md" style="display:none">
            <label for="trnsfr_or" class="block text-xs font-medium text-gray-700 ml-2">Scan Order</label>
            <input type="text" name="trnsfr_or" id="trnsfr_or" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Order" autofocus >
        </div>

        <div x-show="exist2" class="rounded-md" style="display:none">
            <label for="trnsfr_dd" class="block text-xs font-medium text-gray-700 ml-2">Best Before Date</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <input type="text" id="trnsfr_dd" class="text-center bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-1" placeholder="Select Date">
            </div>
        </div>

        <div x-show="exist2" class="rounded-md" style="display:none">
            <label for="trnsfr_loc" class="block text-xs font-medium text-gray-700 ml-2">Scan Location</label>
            <input type="text" name="trnsfr_loc" id="trnsfr_loc" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Location" autofocus >
        </div>

        <div class="mt-1 text-center bg-red-300 rounded-md p2">
            <span class="trnsfr_message"></span>
        </div>

        <div class="flex flex-col mt-2">
            <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-8 lg:px-8">
                <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <h5 class="ml-2">Order #</h5><span class="trnsfr_order" data-id=""></span>
                  <table class="min-w-full divide-y divide-gray-300 trsnfr_tbl">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-2 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                        <th scope="col" class="px-2 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">PLU</th>
                        <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="trnsfr_tbl_body">
                      {{-- tr here --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-end mt-2">
            <button x-show="btn1" @click="prod=!prod,exist2=!exist2,btn1=false,btn2=false,back=!back,cmplt1=!cmplt1" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; New Pallet &nbsp;
                </span>
            </button>
            <button x-show="btn2" @click="prod=!prod,exist1=!exist1,btn1=false,btn2=false,back=!back,cmplt2=!cmplt2" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Existing Pallet &nbsp;
                </span>
            </button>
            <button x-show="back" @click="prod=!prod,exist2=false,exist1=false,btn1=true,btn2=true,back=!back,cmplt1=false,cmplt2=false" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display:none">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button x-show="cmplt1" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display: none">
                <span class="items-center mx-2">
                    &nbsp; Complete &nbsp;
                </span>
            </button>
            <button x-show="cmplt2" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display: none">
                <span class="items-center mx-2">
                    &nbsp; Complete &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

@endsection
