@extends('layouts.app')

@section('content')
<div x-data="{cx:true,qstion:false,scnproducts:false,labelModal:false}">
    <div x-show="cx" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
            <div class="flex justify-center mt-2">
                <div>
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
            </div>

            <div class="flex justify-center mt-2">
                <button @click="cx=!cx,scnproducts=!scnproducts" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; next &nbsp;
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div x-show="scnproducts" id="scnproducts" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg" style="display:none">
        <div class="w-full px-4 py-2 bg-gray-200 rounded-lg shadow sm:rounded-lg">
            <div class="border border-gray-400 rounded-md">
                <label for="scan_pcode" class="sr-only">Label</label>
                <input type="text" name="scan_pcode" id="scan_pcode" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Products" maxlength="60" autofocus >
            </div>
            <div class="flex border border-gray-400 rounded-md my-0.5 grid-cols-2 justify-between">
                <div class="flex items-center justify-start ml-4">
                    <p>Scanned Items # </p><p class="ml-2 font-bold pr_count text-medium">0</p>
                </div>
                <div class="flex items-center justify-end mr-5">
                    <p class="">P.O # </p><p class="ml-2 font-bold prchse_or text-medium">0</p>
                </div>
            </div>
            <div class="mt-1 text-center bg-red-300 rounded-md p2">
                <span class="scan_pcode_message"></span>
            </div>
            <div class="flex flex-col mt-1">
                <div class="overflow-none sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-1 align-middle md:px-8 lg:px-8">
                    <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                      <table class="min-w-full divide-y divide-gray-300 scnproducts">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="py-2 pl-4 pr-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase sm:pl-6">Product Label</th>
                            <th scope="col" class="relative py-2 pl-3 pr-4 sm:pr-6">
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
                <button @click="scnproducts=!scnproducts,cx=!cx" type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; back &nbsp;
                    </span>
                </button>
                <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md gen_label text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="items-center mx-2">
                        &nbsp; Generate Pallet &nbsp;
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div style="display:none" id="pallet_card_no">
        <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
                <div class="mt-2 _prod_loc">
                    <label for="prod_loc" class="sr-only">Scan Location</label>
                    <input type="text" name="prod_loc" id="prod_loc" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm whitespace-nowrap" placeholder="Scan Location" autofocus>
                </div>

                <div class="mt-2 text-center bg-red-300 rounded-md p2">
                    <span class="scan_loc_message2"></span>
                </div>
            </div>
        </div>
        <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
                <div class="flex flex-col mt-2">
                    <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
                        <div class="px-0 mt-1 sm:px-5 sm:mx-auto sm:w-full sm:max-w-lg">
                        <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 scnpallet_tbl">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Label</th>
                                    <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Quantity</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="scnpallet_tbl_body2">
                                <tr>
                                    <td class='py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6'>
                                        <p class='truncate w-36 sm:w-64 overflow-clip'></p>
                                    </td>
                                    <td class='px-3 py-4 text-sm text-gray-500 whitespace-nowrap'></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="flex mt-2 rounded-md shadow-sm">
                            <label for="location2" class="block text-sm font-medium text-gray-700 sr-only"> Location </label>
                            <span class="inline-flex items-center px-3 py-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 sm:text-sm"> Selected Location </span>
                            <input type="text" name="location2" id="location2" data="" class="flex-1 block w-full min-w-0 px-3 py-1 text-black bg-white border border-gray-300 rounded-none rounded-r-md sm:text-sm" placeholder="Location" disabled>
                        </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md save-pallet3 text-md sm:px-2 sm:py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="items-center mx-2">
                                &nbsp; Complete &nbsp;
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-1 print_card sm:mx-auto sm:w-full sm:max-w-lg" style="display: none">
        <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5" id="print_label">

        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
    });
</script>
@endsection

