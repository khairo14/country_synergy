@extends('layouts.app')

@section('content')
    <div class="min-h-full flex items-center justify-center py-1 px-4 sm:px-6 lg:px-8">
        <div class="product_card max-w-xl w-full bg-gray-300 py-5 px-5">
            <div>
                <label for="items" class="flex-inline text-lg font-medium text-gray-700">Scan Items</label>
                <span class="message1 pl-12 ml-12"></span>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="products" id="products" class="scan_products focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-md border-gray-300 rounded-sm" placeholder="Scan code" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2">
                <table class="product_tbl table w-full tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="px-1 items-center">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-center text-sm border border-slate-600">box #</th>
                            <th scope="col" class="table-cell p-2 text-center text-sm border border-slate-600">Product Code</th>
                        </tr>
                    </thead>
                    <tbody class="product_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="mt-2 flex items-center justify-center">
                <button type="button" class="next_scan inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-md font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Next
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="min-h-full flex items-center justify-center py-0 px-4 sm:px-6 lg:px-8">
        <div class="pallete_card max-w-xl w-full bg-gray-300 py-5 px-5" hidden>
            <div>
                <label for="pallete" class="flex-inline text-lg font-medium text-gray-700">Scan Pallete</label>
                <span class="message2 pl-12 ml-12"></span>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="pallete" id="pallete" class="scan_pallete focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-md border-gray-300 rounded-sm" placeholder="Scan Pallete Code" autofocus>
                </div>
            </div>

            <div class="flex items-center justify-center mt-2">
                <table class="pallete_tbl table w-full tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="px-1 items-center">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-center text-sm border border-slate-600">Pallete Code</th>
                        </tr>
                    </thead>
                    <tbody class="pallete_tbl_body">

                    </tbody>
                </table>
            </div>

            <div class="mt-2 flex items-center justify-center">
                <button type="button" class="prev_scan inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-md font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="next2_scan inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-md font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Next
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="min-h-full flex items-center justify-center py-1 px-4 sm:px-6 lg:px-8">
        <div class="bin_card max-w-xl w-full bg-gray-300 py-5 px-5" hidden>
            <div>
                <label for="items" class="flex-inline text-lg font-medium text-gray-700">Scan Bin Location</label>
                <span class="message3 pl-12 ml-12"></span>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="bin_loc" id="bin_loc" class="scan_bin focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-md border-gray-300 rounded-sm" placeholder="Scan code" autofocus>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2">
                <table class="bin_tbl table w-full tk-roboto" style="border-collapse: collapse; border-spacing: 0;">
                    <thead class="px-1 items-center">
                        <tr class="table-row">
                            <th scope="col" class="table-cell p-2 text-center text-sm border border-slate-600">Bin Location</th>
                        </tr>
                    </thead>
                    <tbody class="bin_tbl_body">

                    </tbody>
                </table>
            </div>
            <div class="mt-2 flex items-center justify-center">
                <button type="button" class="prev2_scan inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-md font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
                <button type="button" class="complete_scan inline-flex items-center border border-gray-300 rounded-md px-1 py-1 shadow-sm text-md font-medium text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Complete
                    <span class="inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection
