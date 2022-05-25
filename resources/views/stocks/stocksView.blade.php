@extends('layouts.app')

@section('content')
<div class="grid w-full grid-cols-1 mt-5 sm:grid-cols-2 sm:w-full p-2">
    <div class="grid grid-cols-2 px-4 py-5 overflow-none bg-white rounded-lg shadow sm:p-6">
        <div>
            <label for="exist_cust1" class="block text-xs font-medium text-gray-700">Select Customer</label>
            <select id="exist_cust1" name="exist_cust1" class="block w-52 py-2 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
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
            <label for="exist_cust1" class="block text-xs font-medium text-gray-700">Date</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <input datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" id="srch_date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select Date">
            </div>
        </div>
        <div class="mt-1 text-center bg-red-300 rounded-md col-span-full">
            <span class="srch_message"></span>
        </div>
        <div class="flex justify-end col-start-2 mt-1">
            <button type="button" class="srch_stcks inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-sm sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span class="items-center mx-2">
                    &nbsp; Search &nbsp;
                </span>
            </button>
        </div>
    </div>
</div>
<div class="grid w-full grid-cols-1 mt-1 sm:grid-cols-1 p-2 sm:w-full">
    <div class="grid grid-cols-1 px-4 overflow-none bg-white rounded-lg shadow sm:p-6">
        <div class="overflow-hidden shadow ring-1 w-full rounded-lg ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300" id="stcks_tbl">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">Pallets</th>
                  <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Location</th>
                  <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Qty</th>
                  <th scope="col" class="px-3 py-3 text-left text-xs visible sm:invisible font-medium uppercase tracking-wide text-gray-500">Date Stored</th>
                  <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6 visible sm:invisible">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white" id="stcks_tbl_body">
                {{-- <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <p class='w-24 sm:w-24 truncate overflow-clip'>123213321321313211</p>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><a href="#" class="hover:text-red-800 text-red-500">1351</a></td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">10</td>
                  <td class="whitespace-nowrap px-3 py-4 visible sm:invisible text-sm text-gray-500">05/15/2022</td>
                  <td class="relative whitespace-nowrap visible sm:invisible py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                  </td>
                </tr> --}}
              </tbody>
            </table>
          </div>
    </div>
</div>

<script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>
<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
    });
</script>
@endsection
