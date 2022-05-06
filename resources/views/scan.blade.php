@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-full px-4 py-1 overflow-auto sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-200 order_card">
            <div>
                <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Scan Order</label>
                <span class="px-2 ml-12 message1"></span>
                <div class="relative p-3 mt-1 rounded-md shadow-sm">
                    <input type="text" name="order_id" id="order_id" class="block w-full pr-12 text-center border-gray-300 rounded-sm order_id focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Enter Order Number" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2" id="tbl_cont">
                <table class="w-full divide-y divide-gray-500 order_tbl" id="order_tbl">
                    <thead class="items-center px-1 bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6">Product Code</th>
                            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Product Name</th>
                            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="items-center bg-white divide-y divide-gray-500 order_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-center mt-2">
                <button type="button" class="items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm next0_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" hidden>
                    Next
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center min-h-full px-4 py-1 overflow-auto sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-200 product_card" hidden>
                <div>
                    <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Scan Items</label>
                    <span class="px-2 ml-12 text-center text-white message1"></span>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="text" name="products" id="products" class="block w-full pr-12 border-gray-300 rounded-sm scan_products focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Scan code" autofocus>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-2" id="tbl_cont2">
                    <table class="w-full divide-y divide-gray-500 product_tbl" id="product_tbl">
                        <thead class="items-center px-1 bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6">plu</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Product Name</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Picked Qty</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Ordered Qty</th>
                                <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Remaining</th>
                            </tr>
                        </thead>
                        <tbody class="items-center bg-white divide-y divide-gray-500 product_tbl_body">

                        </tbody>
                    </table>
                </div>

            <div class="flex items-center justify-center mt-2">
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm prev_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm next1_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" hidden>
                    Next
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm complete_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" hidden>
                    Complete
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center min-h-full px-4 py-1 sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-200 bin_card" hidden>
            <div>
                <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Pallet Location</label>
                <span class="px-2 ml-12 text-white message3"></span>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" name="bin_loc" id="bin_loc" class="block w-full pr-12 border-gray-300 rounded-sm scan_bin focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Scan code" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2" id="tbl_cont3">
                <table class="w-full divide-y divide-gray-500 bin_tbl" id="bin_tbl">
                    <thead class="items-center px-1 bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase sm:pl-6">Pallet Location</th>
                            <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="items-center bg-white divide-y divide-gray-500 bin_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-center mt-2">
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm prev1_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm complete1_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Complete
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection
