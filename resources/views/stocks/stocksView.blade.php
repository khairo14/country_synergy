@extends('layouts.app')

@section('content')
<div class="grid w-full grid-cols-1 p-2 mt-1 sm:grid-cols-1 sm:w-full">
    <div class="grid grid-cols-1 px-4 bg-white rounded-lg shadow overflow-none sm:p-1">
        <div class="w-full overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="grid grid-cols-1 px-0 py-1 bg-gray-200 rounded-lg shadow overflow-none sm:p-1">
                <div>
                    <label for="flter" class="block text-xs font-medium text-gray-700">Select Filter</label>
                    <select id="flter" name="flter" class="block py-2 mt-1 text-xs border-gray-300 rounded-md w-72 max-h-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs" placeholder="Select Option">
                            <option value="1">PLU</option>
                            <option selected value="2">Received Date</option>
                    </select>
                </div>
                <div class="flex grid-cols-4 row-start-2 space-x-1 justify-items-start">
                    <div class="">
                        <label for="exist_cust1" class="block text-xs font-medium text-gray-700">Select Customer</label>
                        <select id="exist_cust1" name="exist_cust1" class="block py-1 mt-1 text-xs border-gray-300 rounded-md w-52 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                            @if($customers->isNotEmpty())
                                @foreach ($customers as $cust)
                                    @if($cust->id ==1)
                                        <option selected value="{{$cust->id}}">{{$cust->name}}</option>
                                    @else
                                        <option value="{{$cust->id}}">{{$cust->name}}</option>
                                    @endif
                                @endforeach
                            @else
                                <option selected value="0">No Customer Available</option>
                            @endif
                        </select>
                    </div>
                    <div class="w-auto" id="plu_fltr" style="display: none">
                        <label for="fltr_plu" class="block text-xs font-medium text-gray-700">Select PLU</label>
                        <select id="fltr_plu" name="fltr_plu" class="block w-24 py-1 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                                {{-- @forelse ($plu as $pl)
                                    <option value="{{$pl}}">{{$pl}}</option>
                                @empty
                                    <option value="0">No Product Available</option>
                                @endforelse --}}
                        </select>
                    </div>
                    <div class="" id="rcvd_dte_fltr">
                        <label for="srch_date" class="block text-xs font-medium text-gray-700">Recived From Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="srch_date" class="block py-1 pl-10 text-gray-900 border border-gray-300 rounded-md w-36 bg-gray-50 sm:text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Select Date">
                        </div>

                        <label for="srch_date2" class="block text-xs font-medium text-gray-700">To Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="srch_date2" class="block py-1 pl-10 text-gray-900 border border-gray-300 rounded-md w-36 bg-gray-50 sm:text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Select Date">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="inline-flex items-center px-1 py-1 text-sm font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md srch_stcks sm:px-2 sm:py-1 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="items-center mx-2">
                                &nbsp; Search &nbsp;
                            </span>
                        </button>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="inline-flex items-center px-1 py-1 text-sm font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-md print_stock text-md sm:px-2 sm:py-1 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="items-center mx-2">
                                &nbsp; Print &nbsp;
                            </span>
                        </button>
                    </div>
                </div>

                <div class="mt-1 text-center bg-red-300 rounded-md col-span-full">
                    <span class="srch_message"></span>
                </div>
            </div>
            <div>
                <table class="min-w-full divide-y divide-gray-300" id="stcks_tbl">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">Pallets</th>
                    <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Location</th>
                    <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">PLU</th>
                    <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Product Name</th>
                    <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">Qty</th>
                    {{-- <th scope="col" class="invisible px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:visible">Best Before</th> --}}
                    <th scope="col" class="invisible px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:visible">Received Date</th>
                    <th scope="col" class="relative invisible py-3 pl-3 pr-4 sm:pr-6 sm:visible">
                        <span class="sr-only">Edit</span>
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="stcks_tbl_body">
                    @forelse ($stocks as $stock)
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                <a href="{{url('/stocks/viewProduct/'.$stock['palletid'])}}" data-id="{{$stock['palletid']}}" class="text-indigo-600 hover:text-indigo-900">
                                    <p class='w-24 truncate sm:w-24 overflow-clip'>{{$stock['pallet']}}</p>
                                </a>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4+ text-sm text-gray-500"><a href="#" class="text-red-500 hover:text-red-800">{{$stock['location']}}</a></td>
                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                            @foreach ($stock['sc_line'] as $line)
                                {{$line['plu']}}</br>
                            @endforeach
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                @foreach ($stock['sc_line'] as $line)
                                    {{$line['name']}}</br>
                                @endforeach
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                @foreach ($stock['sc_line'] as $line)
                                    {{$line['count']}}</br>
                                @endforeach
                            </td>
                            <td class='invisible px-3 py-4 text-sm text-gray-500 whitespace-nowrap sm:visible'>{{$stock['stored']}}</td>
                            <td class="relative invisible py-4 pl-3 pr-4 text-sm font-medium text-left whitespace-nowrap sm:visible sm:pr-6">
                                <a href="#" data-id="{{$stock['stockid']}}" class="text-indigo-600 stock_print hover:text-indigo-900">Print Pallet Label</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                No Items Scanned Today - Please Select date / Scan an Item
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
          </div>
    </div>
    @include('stocks.productModal')
</div>
@include('stocks.stockPrint')

<script>
    $(document).ready(function(){
        $("#exist_cust1").select2();
        $("#flter").select2({
            placeholder:"Select Options",
            alignItems: 'center',
        });
        $("#fltr_plu").select2({
            placeholder:"Select PLU",
        });
        var a = new Date();
        $("#srch_date").val($.datepicker.formatDate('d/m/yy', new Date())),
        $( "#srch_date" ).datepicker({
            language: 'en',
            startDate: a,
            setDate: a,
            dateFormat: "d/m/yy",
            autoClose: true,
            changeMonth: true,
            changeYear: true,
        });
        $("#srch_date2").val($.datepicker.formatDate('d/m/yy', new Date())),
        $( "#srch_date2" ).datepicker({
            language: 'en',
            startDate: a,
            setDate: a,
            dateFormat: "d/m/yy",
            autoClose: true,
            changeMonth: true,
            changeYear: true,
        });
    });
</script>
@endsection
