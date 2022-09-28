@extends('layouts.app')

@section('content')
<div x-data="{add:false,edit:false,sloc_val:''}">
    <div class="grid w-full grid-cols-1 sm:grid-cols-2 h-full sm:w-full" id="c0">

        <div class="grid-rows-2 grid-cols-2">
            <div class="grid grid-cols-4 px-4 py-5 h-40 max-h-40 overflow-hidden row-start-1 bg-white rounded-lg shadow sm:p-6" id="c1">
                <div class="w-full col-span-2 mx-auto">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Freezer Locations</dt>
                    <dd class="mt-3 text-4xl font-semibold text-gray-900">{{$num_loc}}</dd>
                    <span class="inline-flex w-full px-4 mt-4 text-sm font-medium bg-gray-200 rounded-md message3" style="display:none">asd</span>
                </div>
                <div class="grid justify-end col-span-2 col-start-3 grid-rows-2 px-6 space-y-1">
                    <label for="loc_upload" class="inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Upload
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <input id="loc_upload" name="loc_upload" type="file" class="sr-only">
                    </label>
                    <button @click="add=!add" dtype="button" class="inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        &nbsp;&nbsp;&nbsp;&nbsp;Add
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                    <button @click="edit=!edit" type="button" class="inline-flex items-center px-4 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        &nbsp;&nbsp;&nbsp;&nbsp;Edit
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="add" class="grid w-full grid-cols-1 px-4 py-5 mt-2 bg-white border-b border-gray-200 rounded-lg sm:w-full sm:mt-4 sm:px-6" style="display:none">
                <div>
                    <div class="relative px-3 py-2 border border-gray-300 rounded-md shadow-sm ">
                        <label for="name" class="absolute inline-block px-1 -mt-px text-xs font-medium text-gray-900 bg-white -top-2 left-2">Freezer Location Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2 text-gray-900 placeholder-gray-500 sm:text-sm" placeholder="Enter Name">
                    </div>
                    <span class="inline-flex w-full px-4 font-medium bg-gray-200 rounded-md text-md message" style="display:none">asd</span>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="add_loc inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="edit" class="grid w-full grid-cols-1 col-span-2 px-4 py-5 mt-5 bg-white border-b border-gray-200 rounded-lg sm:w-1/2 sm:px-6" style="display:none">
                <div >
                    <label for="loc_name" class="block text-xs font-medium text-gray-700">Select Location</label>
                    <select id="loc_name" name="loc_name" class="block w-64 py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                        @if($loc->isNotEmpty())
                            <option value="0">Select Name</option>
                            @foreach ($loc as $l)
                                <option value="{{$l->id}}">{{$l->name}}</option>
                            @endforeach
                        @else
                            <option selected>No Location Available</option>
                        @endif
                    </select>
                </div>
                <div class="w-64 mt-4 border border-gray-500 rounded-sm">
                    <label for="edit_name" class="sr-only">Edit Location Name</label>
                    <input type="edit_name" name="edit_name" id="edit_name" class="block w-full px-2 py-1 border-gray-300 rounded-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Select Location to Edit">
                </div>
                <span class="inline-flex w-full px-4 text-sm font-medium bg-gray-200 rounded-md message1" style="display:none">asd</span>
                <div class="flex justify-end mt-2">
                    <button type="submit" class="edit_loc inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update
                    </button>
                </div>
            </div>
        </div>

        <div class="mx-0 pr-0 grid-cols-1 mt-2 col-start-1 w-full h-full sm:col-start-2 sm:mx-2 sm:pr-2 sm:mt-0">
            {{-- use this to display location names --}}
            <div class="mb-1 w-64">
                <label for="search_bar" class="block text-sm font-medium text-gray-700 sr-only">Search Bar</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="text" name="search" id="search_bar" class="block w-full min-w-0 flex-1 rounded-none rounded-l-md border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onkeyup="searching()" placeholder="Enter Rack">
                    <span class="inline-flex items-center rounded-r-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">Search</span>
                </div>
            </div>
            <div class="border border-collapse h-96 overflow-y-scroll overflow-x-hidden border-gray-200 rounded-lg bg-white">
                <table class="min-w-full divide-y divide-gray-300">
                <thead class="sticky top-0 bg-gray-500">
                    <tr>
                        <th scope="col" class="py-2 pl-2 pr-2 text-sm font-medium tracking-wide text-left text-white sm:pl-6">Rack #</th>
                        <th scope="col" class="py-2 pl-2 pr-2 text-sm font-medium tracking-wide text-center text-white">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"  id="locations">
                    @foreach ($loc as $rack)
                    <tr x-data="{btn_ud{{$rack->id}}:false}">
                        <td class='px-2 py-1 pl-6 pr-2 text-left text-sm w-64 text-gray-500 whitespace-nowrap'>
                            <input class="rack" @click="btn_ud{{$rack->id}}=true" @click.outside="btn_ud{{$rack->id}}=false" type="text" value="{{$rack->name}}"/>
                            <div x-show="btn_ud{{$rack->id}}" class="inline-flex space-x-1" style="display:none">
                                <button class="text-xs p-1 bg-blue-400 rounded-sm hover:bg-blue-500 text-white" data-id="{{$rack->id}}">Update</button>
                                <button class="text-xs p-1 bg-red-400 rounded-sm hover:bg-red-500 text-white" data-id="{{$rack->id}}">Delete</button>
                            </div>
                        </td>
                        @if($rack->status == 'Vacant')
                            <td class='bg-green-800 text-white px-1 py-1 pl-2 pr-2 text-center text-sm font-medium whitespace-nowrap'>{{$rack->status}}</td>
                        @else
                            <td class='bg-red-500 text-white px-1 py-1 pl-2 pr-2 text-center text-sm font-medium whitespace-nowrap'>{{$rack->status}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $("#loc_name").select2();
    });

    function searching(){
        var input = $("#search_bar").val();
        var filter = input.toUpperCase();

        $("#locations tr").each(function(index,value){
            var td = $(this).find('td input').eq(0).val();
            if(td){
                var textValue = td;
                if(textValue.toUpperCase().indexOf(filter) > -1){
                    value.style.display = "";
                }else{
                    value.style.display = "none";
                }
            }

        });
    }
</script>
@endsection
