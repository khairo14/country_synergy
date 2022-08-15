{{-- pallet print label --}}
<div class="bg-white rounded-md p-2">
    <table class="w-full" id="print_table">
        <tbody id="print_table_body" class="w-full">
            <tr class="w-full flex font-medium font-sm text-center">
                <td colspan="2" class="location flex w-full justify-center mt-0"><h1>Loc: {{$location}}</h1></td>
            </tr>
            <tr class="w-full flex font-medium font-sm text-center">
                <td class="lbl w-full border border-collapse border-black">Recieved Date:</td>
                <td class="rcvd_date w-full border border-collapse border-black">{{$storedate}}</td>
            </tr>
            <tr class="w-full flex font-medium font-md text-center">
                <td class="act_purpose w-full border border-collapse border-black">From:</td>
                <td class="clnt w-full border border-collapse border-black">{{$cust[0]->name}}</td>
            </tr>
            {{-- <tr class="w-full flex font-medium font-sm text-center">
                <td class="lbl w-full border border-collapse border-black">Recieved Date:</td>
                <td class="rcvd_date w-full border border-collapse border-black">{{$storedate}}</td>
            </tr> --}}
            <tr class="w-full flex font-medium font-sm text-center">
                <td class="lbl w-full border border-collapse border-black">Quantity</td>
                <td class="rcvd_date w-full border border-collapse border-black">{{$count}}</td>
            </tr>
            {{-- <tr class="flex w-full font-medium font-md text-center">
                <td class="w-full border border-collapse border-black">Qty</td>
                <td class="pallet_qty w-full border border-collapse border-black">{{$qty}}</td>
            </tr> --}}

            <tr class="flex justify-center font-medium font-md text-center">
                <td colspan="2" class="flex justify-center w-full mt-2"><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($label, 'C39',1.5,150,array(0,0,0))}}" alt="barcode" /></td>
            </tr>
            <tr class="flex justify-center font-medium font-md text-center">
                <td colspan="2" class="pallet flex justify-center w-full mt-0" ><h1 class="text-2xl">{{$label}}</h1></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4">
    <button type="button" class="print inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="items-center mx-2">
            &nbsp; Print &nbsp;
        </span>
    </button>
    <button type="button" class="scan_page inline-flex items-center px-1 py-2 font-medium text-white bg-blue-600 border border-gray-300 rounded-md shadow-md text-md sm:px-2 sm:py-2 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="items-center mx-2">
            &nbsp; Scan Again &nbsp;
        </span>
    </button>
</div>
