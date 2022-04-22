@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-full px-4 py-1 sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-300 order_card">
            <div>
                <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Scan Order</label>
                <span class="pl-12 ml-12 message1"></span>
                <div class="relative p-3 mt-1 rounded-md shadow-sm">
                    <input type="text" name="order_id" id="order_id" class="block w-full pr-12 text-center border-gray-300 rounded-sm order_id focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Enter Order Number" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2">
                <table class="table w-full order_tbl tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="items-center px-1">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Product Code</th>
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Product Name</th>
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="order_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-center mt-2">
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm next0_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

    <div class="flex items-center justify-center min-h-full px-4 py-1 sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-300 product_card" hidden>
            <div>
                <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Scan Items</label>
                <span class="pl-12 ml-12 message1"></span>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" name="products" id="products" class="block w-full pr-12 border-gray-300 rounded-sm scan_products focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Scan code" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2">
                <table class="table w-full product_tbl tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="items-center px-1">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">box #</th>
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Product Code</th>
                        </tr>
                    </thead>
                    <tbody class="product_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-center mt-2">
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm next1_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

    <div class="flex items-center justify-center min-h-full px-4 py-0 sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-300 pallete_card" hidden>
            <div>
                <label for="pallete" class="text-lg font-medium text-gray-700 flex-inline">Scan Pallete</label>
                <span class="pl-12 ml-12 message2"></span>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" name="pallete" id="pallete" class="block w-full pr-12 border-gray-300 rounded-sm scan_pallete focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Scan Pallete Code" autofocus>
                </div>
            </div>

            <div class="flex items-center justify-center mt-2">
                <table class="table w-full pallete_tbl tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="items-center px-1">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Pallete Code</th>
                        </tr>
                    </thead>
                    <tbody class="pallete_tbl_body">

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
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm next2_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

    <div class="flex items-center justify-center min-h-full px-4 py-1 sm:px-6 lg:px-8">
        <div class="w-full max-w-xl px-5 py-5 bg-gray-300 bin_card" hidden>
            <div>
                <label for="items" class="text-lg font-medium text-gray-700 flex-inline">Scan Bin Location</label>
                <span class="pl-12 ml-12 message3"></span>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="text" name="bin_loc" id="bin_loc" class="block w-full pr-12 border-gray-300 rounded-sm scan_bin focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-md" placeholder="Scan code" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2">
                <table class="table w-full bin_tbl tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="items-center px-1">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-sm text-center border border-slate-600">Bin Location</th>
                        </tr>
                    </thead>
                    <tbody class="bin_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-center mt-2">
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm prev2_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="inline-flex items-center px-1 py-1 font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm complete_scan text-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
