@extends('layouts.app')

@section('content')
<div id="trnsfr_crd" class="mt-1 sm:mx-auto sm:w-full sm:max-w-lg">
    <div class="px-4 py-4 bg-gray-200 rounded-lg shadow sm:rounded-lg sm:px-5">
        <div class="rounded-md card_1">
            <label for="trnsfr_prod" class="block ml-2 text-xs font-medium text-gray-700">Scan Products</label>
            <input type="text" name="trnsfr_prod" id="trnsfr_prod" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Products" maxlength="60" autofocus >
        </div>

        <div class="rounded-md card_2" style="display:none">
            <label for="trnsfr_pp" class="block ml-2 text-xs font-medium text-gray-700">Scan Pallet</label>
            <input type="text" name="trnsfr_pp" id="trnsfr_pp" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Pallet" autofocus >
        </div>

        <div class="rounded-md card_3" style="display:none">
            <label for="trnsfr_cust1" class="block text-xs font-medium text-gray-700">Select Customer</label>
                <select id="trnsfr_cust1" name="trnsfr_cust1" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                    <option value="0">Select Customer</option>
                    @if($customers->isNotEmpty())
                        @foreach ($customers as $cust)
                            <option value="{{$cust->id}}">{{$cust->name}}</option>
                        @endforeach
                    @else
                        <option selected value="0">No Customer Available</option>
                    @endif
                </select>
                <span class="trnsfr_cust1" data-id=""></span>
        </div>

        <div class="rounded-md card_4" style="display:none">
            <label for="trnsfr_loc" class="block ml-2 text-xs font-medium text-gray-700">Scan Location</label>
            <input type="text" name="trnsfr_loc" id="trnsfr_loc" class="inline-flex w-full p-2 text-center border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Scan Location" autofocus >
        </div>

        <div class="mt-1 text-center rounded-md p2">
            <span class="trnsfr_message"></span>
        </div>

        <div class="flex flex-col mt-2">
            <div class="overflow-hidden sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-8 lg:px-8">
                <div class="card_5" style="display: none">
                    <b>Location:</b><span class="mx-2 loc_name" data-id=""></span>
                </div>
                <div class="card_6" style="display: none">
                    <b>Pallet:</b><span class="mx-2 trnsfr_pp" data-id=""></span>
                </div>
                <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300 trsnfr_tbl">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-2 pl-4 pr-3 text-xs font-medium tracking-wide text-center text-gray-500 uppercase sm:pl-6">Product Label</th>
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
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md trnsfr_new_pallet text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; New Pallet &nbsp;
                </span>
            </button>
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md trnsfr_exist_pallet text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="items-center mx-2">
                    &nbsp; Existing Pallet &nbsp;
                </span>
            </button>
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md bck text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display:none">
                <span class="items-center mx-2">
                    &nbsp; back &nbsp;
                </span>
            </button>
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md complete1 text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display: none">
                <span class="items-center mx-2">
                    &nbsp; Complete &nbsp;
                </span>
            </button>
            <button type="button" class="inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md complete2 text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="display: none">
                <span class="items-center mx-2">
                    &nbsp; Complete &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#trnsfr_cust1").select2();
    });
</script>
@endsection
